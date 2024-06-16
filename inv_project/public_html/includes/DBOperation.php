<?php

/**
* 
*/
class DBOperation
{
	
	private $con;

	function __construct()
	{
		include_once("../database/db.php");
		$db = new Database();
		$this->con = $db->connect();
	}


	//Category name is already registered or not
	private function categoryExists($userid,$cat){
		$pre_stmt = $this->con->prepare("SELECT `cid` FROM `categories` WHERE `user_id` = '".$userid."' AND `category_name` = '".$cat."' ");
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}

	public function addCategory($userid,$parent,$cat){
		if ($this->categoryExists($userid,$cat)) {
			return "CATEGORY_ALREADY_EXISTS";
		}else{
			$pre_stmt = $this->con->prepare("INSERT INTO `categories`(`user_id`,`parent_cat`, `category_name`, `status`)
			 VALUES (?,?,?,?)");
			$status = 1;
			$pre_stmt->bind_param("iisi",$userid,$parent,$cat,$status);
			$result = $pre_stmt->execute() or die($this->con->error);
			if ($result) {
				return "CATEGORY_ADDED";
			}else{
				return 0;
			}
		}

	}


	//Brand name is already registered or not
	private function brandExists($userid,$brand_name){
		$pre_stmt = $this->con->prepare("SELECT `bid` FROM `brands` WHERE `user_id` = '".$userid."' AND `brand_name` = '".$brand_name."' ");
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}

	public function addBrand($userid,$brand_name){
		if ($this->brandExists($userid,$brand_name)) {
			return "BRAND_ALREADY_EXISTS";
		}else{
			$pre_stmt = $this->con->prepare("INSERT INTO `brands`(`user_id`,`brand_name`, `status`)
			 VALUES (?,?,?)");
			$status = 1;
			$pre_stmt->bind_param("isi",$userid,$brand_name,$status);
			$result = $pre_stmt->execute() or die($this->con->error);
			if ($result) {
				return "BRAND_ADDED";
			}else{
				return 0;
			}
		}

	}


	//Product name is already registered or not
	private function productExists($userid,$pro_name){
		$pre_stmt = $this->con->prepare("SELECT `pid` FROM `products` WHERE `user_id` = '".$userid."' AND `product_name` = '".$pro_name."' ");
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}

	public function addProduct($cid,$bid,$userid,$pro_name,$price,$stock,$date){
		if ($this->productExists($userid,$pro_name)) {
			return "PRODUCT_ALREADY_EXISTS";
		}else{
			$pre_stmt = $this->con->prepare("INSERT INTO `products`
				(`cid`, `bid`, `user_id`, `product_name`, `product_price`,
				 `product_stock`, `added_date`, `p_status`)
				 VALUES (?,?,?,?,?,?,?,?)");
			$status = 1;
			$pre_stmt->bind_param("iiisdisi",$cid,$bid,$userid,$pro_name,$price,$stock,$date,$status);
			$result = $pre_stmt->execute() or die($this->con->error);
			if ($result) {
				return "NEW_PRODUCT_ADDED";
			}else{
				return 0;
			}
		}

	}

	public function getAllRecord($table){
		if ($table == "categories") {
			$pre_stmt = $this->con->prepare("SELECT * FROM ".$table." WHERE `user_id` = '".$_SESSION["userid"]."' ORDER BY `category_name`");
		}elseif($table == "brands") {
			$pre_stmt = $this->con->prepare("SELECT * FROM ".$table." WHERE `user_id` = '".$_SESSION["userid"]."' ORDER BY `brand_name`");
		}elseif($table == "products") {
			$pre_stmt = $this->con->prepare("SELECT * FROM ".$table." WHERE `user_id` = '".$_SESSION["userid"]."' ORDER BY `product_name`");
		}else{
			$pre_stmt = $this->con->prepare("SELECT * FROM ".$table." WHERE `user_id` = '".$_SESSION["userid"]."'");
		}
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		$rows = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}
		return "NO_DATA";
	}
}

//$opr = new DBOperation();
//echo $opr->addCategory(1,"Mobiles");
//echo "<pre>";
//print_r($opr->getAllRecord("categories"));
?>