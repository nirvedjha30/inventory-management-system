<?php

/**
* 
*/
class Manage
{
	
	private $con;

	function __construct()
	{
		include_once("../database/db.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	public function manageRecordWithPagination($table,$pno){
		$a = $this->pagination($this->con,$table,$pno,5);
		if ($table == "categories") {
			$sql = "SELECT p.cid,p.user_id,p.category_name as category, c.category_name as parent, p.status FROM categories p LEFT JOIN categories c ON p.parent_cat=c.cid WHERE p.user_id = '".$_SESSION["userid"]."' ORDER BY `category` ".$a["limit"];
		}else if($table == "products"){
			$sql = "SELECT p.pid,p.user_id,p.product_name,c.category_name,b.brand_name,p.product_price,p.product_stock,p.added_date,p.p_status FROM products p,brands b,categories c WHERE p.bid = b.bid AND p.cid = c.cid AND p.user_id = '".$_SESSION["userid"]."' ORDER BY p.product_name ".$a["limit"];
		}else if($table == "invoice"){
			$sql = "SELECT invoice_no, user_id, customer_name, order_date, sub_total, gst, discount, net_total, paid, due, payment_type FROM invoice WHERE invoice_no AND user_id = '".$_SESSION["userid"]."' ORDER BY `invoice_no` DESC ".$a["limit"];
		}else{
			$sql = "SELECT * FROM ".$table." WHERE `user_id` = '".$_SESSION["userid"]."' ORDER BY `brand_name` ".$a["limit"];
		}
		$result = $this->con->query($sql) or die($this->con->error);
		$rows = array();
		if($result->num_rows > 0){
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			}
		}
		return ["rows"=>$rows,"pagination"=>$a["pagination"]];

	}

	private function pagination($con,$table,$pno,$n){
		$query = $con->query("SELECT COUNT(*) as rowss FROM ".$table." WHERE user_id = ".$_SESSION["userid"]." ");
		$row = mysqli_fetch_assoc($query);
		//$totalRecords = 100000;
		$pageno = $pno;
		$numberOfRecordsPerPage = $n;

		$last = ceil($row["rowss"]/$numberOfRecordsPerPage);

		$pagination = "<ul class='pagination'>";

		if ($last != 1) {
			if ($pageno > 1) {
				$previous = "";
				$previous = $pageno - 1;
				$pagination .= "<li class='page-item'><a class='page-link' pn='".$previous."' href='#' style='color:#333;'> Previous </a></li></li>";
			}
			for($i=$pageno - 5;$i< $pageno ;$i++){
				if ($i > 0) {
					$pagination .= "<li class='page-item'><a class='page-link' pn='".$i."' href='#'> ".$i." </a></li>";
				}
				
			}
			$pagination .= "<li class='page-item'><a class='page-link' pn='".$pageno."' href='#' style='color:#333;'> $pageno </a></li>";
			for ($i=$pageno + 1; $i <= $last; $i++) { 
				$pagination .= "<li class='page-item'><a class='page-link' pn='".$i."' href='#'> ".$i." </a></li>";
				if ($i > $pageno + 4) {
					break;
				}
			}
			if ($last > $pageno) {
				$next = $pageno + 1;
				$pagination .= "<li class='page-item'><a class='page-link' pn='".$next."' href='#' style='color:#333;'> Next </a></li></ul>";
			}
		}
	//LIMIT 0,10
		//LIMIT 20,10
		$limit = "LIMIT ".($pageno - 1) * $numberOfRecordsPerPage.",".$numberOfRecordsPerPage;

		return ["pagination"=>$pagination,"limit"=>$limit];
	}

	public function deleteProfileRecord($table,$pk,$id){
		$pre_stmt = $this->con->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
		$pre_stmt->bind_param("i",$id);
		$result = $pre_stmt->execute() or die($this->con->error);
		if ($result) {
			return "DELETED";
		}
	}

	public function deleteRecord($table,$pk,$id){
		if($table == "categories"){
			$pre_stmt = $this->con->prepare("SELECT ".$id." FROM categories WHERE parent_cat = ?");
			$pre_stmt->bind_param("i",$id);
			$pre_stmt->execute();
			$result = $pre_stmt->get_result() or die($this->con->error);
			if ($result->num_rows > 0) {
				return "DEPENDENT_CATEGORY";
			}else{
				$pre_stmt = $this->con->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
				$pre_stmt->bind_param("i",$id);
				$result = $pre_stmt->execute() or die($this->con->error);
				if ($result) {
					return "CATEGORY_DELETED";
				}
			}
		}else{
			$pre_stmt = $this->con->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
			$pre_stmt->bind_param("i",$id);
			$result = $pre_stmt->execute() or die($this->con->error);
				if ($result) {
					return "DELETED";
			}
		}
	}

	public function activeRecord($table,$pk,$id){
		if($table == "categories" || $table == "brands"){
				$pre_stmt = $this->con->prepare("UPDATE ".$table." SET status = 1 WHERE ".$pk." = ?");
				$pre_stmt->bind_param("i",$id);
				$result = $pre_stmt->execute() or die($this->con->error);
				if ($result) {
					return "ACTIVATED";
				}
		}elseif ($table == "products") {
				$pre_stmt = $this->con->prepare("UPDATE ".$table." SET p_status = 1 WHERE ".$pk." = ?");
				$pre_stmt->bind_param("i",$id);
				$result = $pre_stmt->execute() or die($this->con->error);
				if ($result) {
					return "ACTIVATED";
				}
		}
	}

	public function deactiveRecord($table,$pk,$id){
		if($table == "categories"){
			$pre_stmt = $this->con->prepare("SELECT ".$id." FROM categories WHERE parent_cat = ?");
			$pre_stmt->bind_param("i",$id);
			$pre_stmt->execute();
			$result = $pre_stmt->get_result() or die($this->con->error);
			if ($result->num_rows > 0) {
				return "DEPENDENT_CATEGORY";
			}else{
				$pre_stmt = $this->con->prepare("SELECT ".$id." FROM products WHERE cid = ?");
				$pre_stmt->bind_param("i",$id);
				$pre_stmt->execute();
				$result = $pre_stmt->get_result() or die($this->con->error);
				if ($result->num_rows > 0) {
					return "DEPENDENT_PRODUCT";
				}else{
					$pre_stmt = $this->con->prepare("UPDATE ".$table." SET status = 2 WHERE ".$pk." = ?");
					$pre_stmt->bind_param("i",$id);
					$result = $pre_stmt->execute() or die($this->con->error);
					if ($result) {
						return "CATEGORY_DEACTIVATED";
					}

				}
			}
		 }elseif ($table == "brands") {
		 	$pre_stmt = $this->con->prepare("SELECT ".$id." FROM products WHERE bid = ?");
			$pre_stmt->bind_param("i",$id);
			$pre_stmt->execute();
			$result = $pre_stmt->get_result() or die($this->con->error);
			if ($result->num_rows > 0) {
				return "DEPENDENT_PRODUCT";
			}else{
				$pre_stmt = $this->con->prepare("UPDATE ".$table." SET status = 2 WHERE ".$pk." = ?");
				$pre_stmt->bind_param("i",$id);
				$result = $pre_stmt->execute() or die($this->con->error);
				if ($result) {
					return "BRAND_DEACTIVATED";
				}
			}
		 }elseif ($table == "products") {
			$pre_stmt = $this->con->prepare("UPDATE ".$table." SET p_status = 2 WHERE ".$pk." = ?");
			$pre_stmt->bind_param("i",$id);
			$result = $pre_stmt->execute() or die($this->con->error);
			if ($result) {
				return "PRODUCT_DEACTIVATED";
			}
		}
	}

	public function deleteOrderRecord($table,$pk,$id){
		if($table == "invoice_details" || $table == "invoice"){
			$pre_stmt = $this->con->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
			$pre_stmt->bind_param("i",$id);
			$result = $pre_stmt->execute() or die($this->con->error);
				if ($result) {
					return "DELETED";
			}
		}
	}


	public function getSingleRecord($table,$pk,$id){
		$pre_stmt = $this->con->prepare("SELECT * FROM ".$table." WHERE ".$pk."= ? LIMIT 1");
		$pre_stmt->bind_param("i",$id);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
		}
		return $row;
	}

	//Table value name is already registered or not (example: category, brand, product, order)
	private function tableExists($id,$table,$colname,$name,$preid){
		$pre_stmt = $this->con->prepare("SELECT ".$id." FROM ".$table." WHERE `user_id` = '".$_SESSION["userid"]."' AND ".$colname." = '".$name."' AND ".$id." != '".$preid."' ");
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}

	public function update_record($table,$where,$fields,$id,$colname,$name,$preid){
		if ($this->tableExists($id,$table,$colname,$name,$preid)) {
			return "ALREADY_EXISTS";
		 }else{
			$sql = "";
			$condition = "";
			foreach ($where as $key => $value) {
				// id = '5' AND m_name = 'something'
				$condition .= $key . "='" . $value . "' AND ";
			}
			$condition = substr($condition, 0, -5);
			foreach ($fields as $key => $value) {
				//UPDATE table SET m_name = '' , qty = '' WHERE id = '';
				$sql .= $key . "='".$value."', ";
			}
			$sql = substr($sql, 0,-2);
			$sql = "UPDATE ".$table." SET ".$sql." WHERE ".$condition." AND `user_id` = '".$_SESSION["userid"]."' ";
			if(mysqli_query($this->con,$sql)){
				return "UPDATED";
			}
		}
	}


	public function storeCustomerOrderInvoice($orderdate,$userid,$cust_name,$ar_tqty,$ar_qty,$ar_price,$ar_pro_name,$sub_total,$gst,$discount,$net_total,$paid,$due,$payment_type){
		$pre_stmt = $this->con->prepare("INSERT INTO 
			`invoice`(`user_id`, `customer_name`, `order_date`, `sub_total`,
			 `gst`, `discount`, `net_total`, `paid`, `due`, `payment_type`) VALUES (?,?,?,?,?,?,?,?,?,?)");
		$pre_stmt->bind_param("issdddddds",$userid,$cust_name,$orderdate,$sub_total,$gst,$discount,$net_total,$paid,$due,$payment_type);
		$pre_stmt->execute() or die($this->con->error);
		$invoice_no = $pre_stmt->insert_id;
		if ($invoice_no != null) {
			for ($i=0; $i < count($ar_price) ; $i++) {

				//Here we are finding the remaing quantity after giving customer
				$rem_qty = $ar_tqty[$i] - $ar_qty[$i];
				if ($rem_qty < 0) {
					return "ORDER_FAIL_TO_COMPLETE";
				}else{
					//Update Product stock
					$sql = "UPDATE products SET product_stock = '$rem_qty' WHERE product_name = '".$ar_pro_name[$i]."'";
					$this->con->query($sql);
				}


				$insert_product = $this->con->prepare("INSERT INTO `invoice_details`(`invoice_no`, `user_id`, `product_name`, `price`, `qty`)
				 VALUES (?,?,?,?,?)");
				$insert_product->bind_param("iisdd",$invoice_no,$userid,$ar_pro_name[$i],$ar_price[$i],$ar_qty[$i]);
				$insert_product->execute() or die($this->con->error);
			}

			return $invoice_no;
		}



	}



	
}

//$obj = new Manage();
//echo "<pre>";
//print_r($obj->manageRecordWithPagination("categories",1));
//echo $obj->deleteRecord("categories","cid",14);
//print_r($obj->getSingleRecord("categories","cid",1));
//echo $obj->update_record("categories",["cid"=>1],["parent_cat"=>0,"category_name"=>"Electro","status"=>1]);
?>