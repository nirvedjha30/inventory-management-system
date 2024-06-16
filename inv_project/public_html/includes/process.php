<?php
include_once("../database/constants.php");
include_once("user.php");
include_once("DBOperation.php");
include_once("manage.php");

//For Registration Processsing
if (isset($_POST["username"]) AND isset($_POST["email"])) {
	$user = new User();
	$result = $user->createUserAccount($_POST["username"],$_POST["email"],$_POST["password1"],$_POST["usertype"]);
	echo $result;
	exit();
}

//For Login Processing
if (isset($_POST["log_email"]) AND isset($_POST["log_password"])) {
	$user = new User();
	$result = $user->userLogin($_POST["log_email"],$_POST["log_password"]);
	echo $result;
	exit();
}

//Recover User Account (Email Send Verify Form)
if (isset($_POST["recover_email"])) {
	$user = new User();
	$result = $user->recoverUserAccount($_POST["recover_email"]);
	echo $result;
	exit();
}

//Reset User Account Password
if (isset($_POST["reset_token"]) AND isset($_POST["reset_password1"])) {
	$user = new User();
	$result = $user->resetUserAccountPassword($_POST["reset_token"],$_POST["reset_password1"]);
	echo $result;
	exit();
}

//Delete Profile
if (isset($_POST["dlog_email"]) AND isset($_POST["dlog_password"])) {
	$user = new User();
	$result = $user->deleteUserIdVerify($_POST["dlog_email"],$_POST["dlog_password"]);
	echo $result;
	exit();
}

//Update Profile
if (isset($_POST["update_username"]) AND isset($_POST["update_email"])) {
	$user = new User();
	$result = $user->updateUserAccount($_POST["update_username"],$_POST["update_email"],$_POST["update_usertype"]);
	$user->sessionUpdateUserAccount($_POST["update_email"]);
	echo $result;
	exit();
}

//Change Profile Password
if (isset($_POST["change_password_email"]) AND isset($_POST["current_password"])) {
	$user = new User();
	$result = $user->updateUserAccountPassword($_POST["change_password_email"],$_POST["current_password"],$_POST["update_password1"]);
	echo $result;
	exit();
}

//To get Category
if (isset($_POST["getCategory"])) {
	$obj = new DBOperation();
	$rows = $obj->getAllRecord("categories");
	foreach ($rows as $row) {
		if ($row["status"] != 0 AND $row["user_id"] == $_SESSION["userid"]) {
			echo "<option value='".$row["cid"]."'>".$row["category_name"]."</option>";
		}	
	}
	exit();
}

//Fetch Brand
if (isset($_POST["getBrand"])) {
	$obj = new DBOperation();
	$rows = $obj->getAllRecord("brands");
	foreach ($rows as $row) {
		if ($row["status"] != 0 AND $row["user_id"] == $_SESSION["userid"]) {
			echo "<option value='".$row["bid"]."'>".$row["brand_name"]."</option>";
		}
	}
	exit();
}

//Add Category
if (isset($_POST["category_name"]) AND isset($_POST["parent_cat"])) {
	$obj = new DBOperation();
	$result = $obj->addCategory($_POST["user_id"],$_POST["parent_cat"],$_POST["category_name"]);
	echo $result;
	exit();
}

//Add Brand
if (isset($_POST["brand_name"])) {
	$obj = new DBOperation();
	$result = $obj->addBrand($_POST["user_id"],$_POST["brand_name"]);
	echo $result;
	exit();
}

//Add Product
if (isset($_POST["added_date"]) AND isset($_POST["product_name"])) {
	$obj = new DBOperation();
	$result = $obj->addProduct($_POST["select_cat"],
							$_POST["select_brand"],
							$_POST["user_id"],
							$_POST["product_name"],
							$_POST["product_price"],
							$_POST["product_qty"],
							$_POST["added_date"]);
	echo $result;
	exit();
}

//Manage Category
if (isset($_POST["manageCategory"])) {
	$m = new Manage();
	$result = $m->manageRecordWithPagination("categories",$_POST["pageno"]);
	$rows = $result["rows"];
	$pagination = $result["pagination"];
	if (count($rows) > 0) {
		$n = (($_POST["pageno"] - 1) * 5)+1;
		foreach ($rows as $row) {
			?>
				<tr>
			        <td><?php echo $n; ?></td>
			        <td><?php echo $row["category"]; ?></td>
			        <td><?php echo $row["parent"]; ?></td>



			        <?php if ($row["status"] == 0){ ?>
			        	<td><a href="#" activeid="<?php echo $row['cid']; ?>" class="btn btn-danger btn-sm active_cat">Deactive</a></td>
			        <?php }else{ ?>
			        	<td><a href="#" deactiveid="<?php echo $row['cid']; ?>" class="btn btn-success btn-sm deactive_cat">Active</a></td>
			        <?php } ?>
			        

			        
			        <td>
			        	<a href="#" did="<?php echo $row['cid']; ?>" class="btn btn-danger btn-sm del_cat"><i class="fa fa-trash">&nbsp;</i>Delete</a>
			        	<?php if ($row["status"] != 0){ ?>
			        	<a href="#" eid="<?php echo $row['cid']; ?>" data-toggle="modal" data-target="#form_category" class="btn btn-info btn-sm edit_cat"><i class="fa fa-edit">&nbsp;</i>Edit</a>
			        	<?php } ?>
			        </td>
			      </tr>
			<?php
			$n++;
		}
		?>
			<tr><td colspan="5"><?php echo $pagination; ?></td></tr>
		<?php
		exit();
	}else{
		?>
			<tr><td colspan="5" style="text-align: center;">No Category is Available!</td></tr>
		<?php
	}
}


//Delete Category
if (isset($_POST["deleteCategory"])) {
	$m = new Manage();
	$result = $m->deleteRecord("categories","cid",$_POST["id"]);
	echo $result;
}

//Active Category
if (isset($_POST["activeCategory"])) {
	$m = new Manage();
	$result = $m->activeRecord("categories","cid",$_POST["id"]);
	echo $result;
}

//Deactive Category
if (isset($_POST["deactiveCategory"])) {
	$m = new Manage();
	$result = $m->deactiveRecord("categories","cid",$_POST["id"]);
	echo $result;
}

//Update Category
if (isset($_POST["updateCategory"])) {
	$m = new Manage();
	$result = $m->getSingleRecord("categories","cid",$_POST["id"]);
	echo json_encode($result);
	exit();
}

//Update Record after getting data
if (isset($_POST["update_category"])) {
	$m = new Manage();
	$id = $_POST["cid"];
	$name = $_POST["update_category"];
	$parent = $_POST["parent_cat"];
	$result = $m->update_record("categories",["cid"=>$id],["parent_cat"=>$parent,"category_name"=>$name,"status"=>1],"cid","category_name",$name,$id);
	echo $result;
}

//------------------Brand---------------------


//Manage Brand
if (isset($_POST["manageBrand"])) {
	$m = new Manage();
	$result = $m->manageRecordWithPagination("brands",$_POST["pageno"]);
	$rows = $result["rows"];
	$pagination = $result["pagination"];
	if (count($rows) > 0) {
		$n = (($_POST["pageno"] - 1) * 5)+1;
		foreach ($rows as $row) {
			?>
				<tr>
			        <td><?php echo $n; ?></td>
			        <td><?php echo $row["brand_name"]; ?></td>
			        


			        <?php if ($row["status"] == 0){ ?>
			        	<td><a href="#" activeid="<?php echo $row['bid']; ?>" class="btn btn-danger btn-sm active_brand">Deactive</a></td>
			        <?php }else{ ?>
			        	<td><a href="#" deactiveid="<?php echo $row['bid']; ?>" class="btn btn-success btn-sm deactive_brand">Active</a></td>
			        <?php } ?>


			        <td>
			        	<a href="#" did="<?php echo $row['bid']; ?>" class="btn btn-danger btn-sm del_brand"><i class="fa fa-trash">&nbsp;</i>Delete</a>
			        	<?php if ($row["status"] != 0){ ?>
			        	<a href="#" eid="<?php echo $row['bid']; ?>" data-toggle="modal" data-target="#form_brand" class="btn btn-info btn-sm edit_brand"><i class="fa fa-edit">&nbsp;</i>Edit</a>
			        	<?php } ?>
			        </td>
			      </tr>
			<?php
			$n++;
		}
		?>
			<tr><td colspan="4"><?php echo $pagination; ?></td></tr>
		<?php
		exit();
	}else{
		?>
			<tr><td colspan="4" style="text-align: center;">No Brand is Available!</td></tr>
		<?php
	}
}

//Delete Brand
if (isset($_POST["deleteBrand"])) {
	$m = new Manage();
	$result = $m->deleteRecord("brands","bid",$_POST["id"]);
	echo $result;
}

//Active Brand
if (isset($_POST["activeBrand"])) {
	$m = new Manage();
	$result = $m->activeRecord("brands","bid",$_POST["id"]);
	echo $result;
}


//Deactive Brand
if (isset($_POST["deactiveBrand"])) {
	$m = new Manage();
	$result = $m->deactiveRecord("brands","bid",$_POST["id"]);
	echo $result;
}


//Update Brand
if (isset($_POST["updateBrand"])) {
	$m = new Manage();
	$result = $m->getSingleRecord("brands","bid",$_POST["id"]);
	echo json_encode($result);
	exit();
}

//Update Record after getting data
if (isset($_POST["update_brand"])) {
	$m = new Manage();
	$id = $_POST["bid"];
	$name = $_POST["update_brand"];
	$result = $m->update_record("brands",["bid"=>$id],["brand_name"=>$name,"status"=>1],"bid","brand_name",$name,$id);
	echo $result;
}

//----------------Products---------------------

if (isset($_POST["manageProduct"])) {
	$m = new Manage();
	$result = $m->manageRecordWithPagination("products",$_POST["pageno"]);
	$rows = $result["rows"];
	$pagination = $result["pagination"];
	if (count($rows) > 0) {
		$n = (($_POST["pageno"] - 1) * 5)+1;
		foreach ($rows as $row) {
			?>
				<tr>
			        <td><?php echo $n; ?></td>
			        <td><?php echo $row["product_name"]; ?></td>
			        <td><?php echo $row["category_name"]; ?></td>
			        <td><?php echo $row["brand_name"]; ?></td>
			        <td><?php echo $row["product_price"]; ?></td>
			        <td><?php echo $row["product_stock"]; ?></td>
			        <td><?php echo $row["added_date"]; ?></td>
			        

			        <?php if ($row["p_status"] == 0){ ?>
			        	<td><a href="#" activeid="<?php echo $row['pid']; ?>" class="btn btn-danger btn-sm active_product">Deactive</a></td>
			        <?php }else{ ?>
			        	<td><a href="#" deactiveid="<?php echo $row['pid']; ?>" class="btn btn-success btn-sm deactive_product">Active</a></td>
			        <?php } ?>


			        <td>
			        	<a href="#" did="<?php echo $row['pid']; ?>" class="btn btn-danger btn-sm del_product"><i class="fa fa-trash">&nbsp;</i>Delete</a>
			        	<?php if ($row["p_status"] != 0){ ?>
			        	<a href="#" eid="<?php echo $row['pid']; ?>" data-toggle="modal" data-target="#form_products" class="btn btn-info btn-sm edit_product"><i class="fa fa-edit">&nbsp;</i>Edit</a>
			        	<?php } ?>
			        </td>
			      </tr>
			<?php
			$n++;
		}
		?>
			<tr><td colspan="9"><?php echo $pagination; ?></td></tr>
		<?php
		exit();
	}else{
		?>
			<tr><td colspan="9" style="text-align: center;">No Product is Available!</td></tr>
		<?php
	}
}

//Delete Product
if (isset($_POST["deleteProduct"])) {
	$m = new Manage();
	$result = $m->deleteRecord("products","pid",$_POST["id"]);
	echo $result;
}

//Active Product
if (isset($_POST["activeProduct"])) {
	$m = new Manage();
	$result = $m->activeRecord("products","pid",$_POST["id"]);
	echo $result;
}


//Deactive Product
if (isset($_POST["deactiveProduct"])) {
	$m = new Manage();
	$result = $m->deactiveRecord("products","pid",$_POST["id"]);
	echo $result;
}


//Update Product
if (isset($_POST["updateProduct"])) {
	$m = new Manage();
	$result = $m->getSingleRecord("products","pid",$_POST["id"]);
	echo json_encode($result);
	exit();
}

//Update Record after getting data
if (isset($_POST["update_product"])) {
	$m = new Manage();
	$id = $_POST["pid"];
	$name = $_POST["update_product"];
	$cat = $_POST["select_cat"];
	$brand = $_POST["select_brand"];
	$price = $_POST["product_price"];
	$qty = $_POST["product_qty"];
	$date = $_POST["added_date"];
	$result = $m->update_record("products",["pid"=>$id],["cid"=>$cat,"bid"=>$brand,"product_name"=>$name,"product_price"=>$price,"product_stock"=>$qty,"added_date"=>$date],"pid","product_name",$name,$id);
	echo $result;
}

//-------------------------Order Processing--------------

if (isset($_POST["getNewOrderItem"])) {
	$obj = new DBOperation();
	$rows = $obj->getAllRecord("products");
	?>
	<tr>
		    <td><b class="number">1</b></td>
		    <td>
		        <select name="pid[]" id="pid" class="form-control form-control-sm pid" required>
		            <option value="">Choose Product</option>
		            <?php 
		            	foreach ($rows as $row) {
		            		if ($row["p_status"] != 0 AND $row["user_id"] == $_SESSION["userid"]) {
		            			?><option value="<?php echo $row['pid']; ?>"><?php echo $row["product_name"]; ?></option><?php
		            		}
		            	}
		            ?>
		        </select>
		    </td>
		    <td><input name="tqty[]" readonly type="text" class="form-control form-control-sm tqty"></td>   
		    <td><input name="qty[]" type="text" class="form-control form-control-sm qty" required></td>
		    <td><input name="price[]" type="text" class="form-control form-control-sm price" readonly>
		    <span><input name="pro_name[]" type="hidden" class="form-control form-control-sm pro_name"></span></td>
		    <td>Rs.<span class="amt">0</span></td>
	</tr>
	<?php
	exit();
}

//Manage Order
if (isset($_POST["manageOrder"])) {
	$m = new Manage();
	$result = $m->manageRecordWithPagination("invoice",$_POST["pageno"]);
	$rows = $result["rows"];
	$pagination = $result["pagination"];
	if (count($rows) > 0) {
		$n = (($_POST["pageno"] - 1) * 5)+1;
		foreach ($rows as $row) {
			?>
				<tr>
			        <td><?php echo $n; ?></td>
			        <td><?php echo $row["customer_name"]; ?></td>
			        <td><?php echo $row["order_date"]; ?></td>
			        <td><?php echo $row["sub_total"]; ?></td>
			        <td><?php echo $row["gst"]; ?></td>
			        <td><?php echo $row["discount"]; ?></td>
			        <td><?php echo $row["net_total"]; ?></td>0
			        <td><?php echo $row["paid"]; ?></td>
			        <td><?php echo $row["due"]; ?></td>
			        <td><?php echo $row["payment_type"]; ?></td>
			        <td><a href="./PDF_INVOICE/PDF_INVOICE_<?php echo $row["invoice_no"]; ?>.pdf" class="btn btn-white btn-sm edit_order" style="color:red; border: 2px solid red;"><i class="fa fa-file-pdf-o" style="color: red;">&nbsp;</i>PDF</a></td>
			        <!-- <td><a href="#" class="btn btn-success btn-sm">Active</a></td> -->
			        <td>
			        	<a href="#" did="<?php echo $row['invoice_no']; ?>" class="btn btn-danger btn-sm del_order"><i class="fa fa-trash">&nbsp;</i>Delete</a>
			        	<!-- <a href="#" eid=" //echo $row['invoice_no']; " class="btn btn-info btn-sm edit_order"><i class="fa fa-edit">&nbsp;</i>Edit</a> -->
			        </td>
			      </tr>
			<?php
			$n++;
		}
		?>
			<tr><td colspan="13"><?php echo $pagination; ?></td></tr>
		<?php
		exit();
	}else{
		?>
			<tr><td colspan="13" style="text-align: center;">No Order is Available!</td></tr>
		<?php
	}
}

//Delete 
if (isset($_POST["deleteOrder"])) {
	$m = new Manage();
	$result = $m->deleteOrderRecord("invoice_details","invoice_no",$_POST["id"]);
	$result = $m->deleteOrderRecord("invoice","invoice_no",$_POST["id"]);
	//unlink("C:xampp\htdocs\inv_project\public_html\PDF_INVOICE\PDF_INVOICE_".$_POST["id"].".pdf");
	unlink("..\PDF_INVOICE\PDF_INVOICE_".$_POST["id"].".pdf");
	echo $result;
}

//Get price and qty of one item
if (isset($_POST["getPriceAndQty"])) {
	$m = new Manage();
	$result = $m->getSingleRecord("products","pid",$_POST["id"]);
	echo json_encode($result);
	exit();
}


if (isset($_POST["order_date"]) AND isset($_POST["cust_name"])) {
	
	$orderdate = $_POST["order_date"];
	$userid = $_POST["user_id"];
	$cust_name = $_POST["cust_name"];


	//Now getting array from order_form
	$ar_tqty = $_POST["tqty"];
	$ar_qty = $_POST["qty"];
	$ar_price = $_POST["price"];
	$ar_pro_name = $_POST["pro_name"];


	$sub_total = $_POST["sub_total"];
	$gst = $_POST["gst"];
	$discount = $_POST["discount"];
	$net_total = $_POST["net_total"];
	$paid = $_POST["paid"];
	$due = $_POST["due"];
	$payment_type = $_POST["payment_type"];


	$m = new Manage();
	echo $result = $m->storeCustomerOrderInvoice($orderdate,$userid,$cust_name,$ar_tqty,$ar_qty,$ar_price,$ar_pro_name,$sub_total,$gst,$discount,$net_total,$paid,$due,$payment_type);




}

?>