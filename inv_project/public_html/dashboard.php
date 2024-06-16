<?php
include_once("./database/constants.php");
if (!isset($_SESSION["userid"])) {
	header("location:".DOMAIN."/");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Inventory Management System</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
 	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 	<link rel="stylesheet" type="text/css" href="./includes/style.css">
 	<script type="text/javascript" src="./js/main.js"></script>
 </head>
<body>
<div class="overlay"><div class="loader"></div></div>
	<!-- Navbar -->
	<?php include_once("./templates/header.php"); ?>
	<br/><br/>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="card mx-auto">
					<div class="card-header" style="text-align:center;"><h4><b>Your Profile</b></h4></div>
				  <img class="card-img-top mx-auto" style="width:60%;" src="./images/user.png" alt="Card image cap">
				  <div class="card-body">
				    <h4 class="card-title">Profile Information</h4>
				    <p class="card-text"><i class="fa fa-user">&nbsp;</i>Name : <?php echo $_SESSION["username"]; ?></p>
				    <p class="card-text"><i class="fa fa-user">&nbsp;</i>User Type : <?php echo $_SESSION["usertype"]; ?></p>
				    <p class="card-text"><i class="fa fa-calendar">&nbsp;</i>Last Login : <?php echo $_SESSION["last_login"]; ?></p>
				    <a href="profile.php">More Info</a><br/>
				    <a href="#" data-toggle="modal" data-target="#form_profile" class="btn btn-primary"><i class="fa fa-edit">&nbsp;</i>Edit Profile</a>
				    <a href="#" data-toggle="modal" data-target="#form_change_profile_password">Change Password</a>
				  </div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="jumbotron" style="width:100%;height:100%;">
					<h1>Welcome <?php echo $_SESSION["username"]; ?>,</h1>
					<p>Have a nice day</p>
					<div class="row">
						<div class="col-sm-6">
							<iframe src="http://free.timeanddate.com/clock/i616j2aa/n1993/szw160/szh160/cf100/hnce1ead6" frameborder="0" width="160" height="160"></iframe>

						</div>
						<div class="col-sm-6">
							<div class="card">
						      <div class="card-body">
						        <h4 class="card-title">New Orders</h4>
						        <p class="card-text">Here you can manage your orders and make invoices and create new orders.</p>
						        <a href="new_order.php" class="btn btn-info"><i class="fa fa-plus">&nbsp;</i>New Orders</a>
						        <a href="manage_order.php" class="btn btn-success"><i class="fa fa-edit">&nbsp;</i>Manage</a>
						      </div>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<p></p>
	<p></p>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Categories</h4>
						<p class="card-text">Here you can manage your categories and add new parent and sub categories.</p>
						<a href="#" data-toggle="modal" data-target="#form_category" class="btn btn-info"><i class="fa fa-plus">&nbsp;</i>Add</a>
						<a href="manage_categories.php" class="btn btn-success"><i class="fa fa-edit">&nbsp;</i>Manage</a>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Brands</h4>
						<p class="card-text">Here you can manage your brand and add new brand.</p>
						<a href="#" data-toggle="modal" data-target="#form_brand" class="btn btn-info"><i class="fa fa-plus">&nbsp;</i>Add</a>
						<a href="manage_brand.php" class="btn btn-success"><i class="fa fa-edit">&nbsp;</i>Manage</a>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Products</h4>
						<p class="card-text">Here you can manage your products and add new products.</p>
						<a href="#" data-toggle="modal" data-target="#form_products" class="btn btn-info"><i class="fa fa-plus">&nbsp;</i>Add</a>
						<a href="manage_product.php" class="btn btn-success"><i class="fa fa-edit">&nbsp;</i>Manage</a>
					</div>
				</div>
			</div>
		</div>
	</div>


	
	<?php
	//Categpry Form
	include_once("./templates/category.php");
	 ?>
	 <?php
	//Brand Form
	include_once("./templates/brand.php");
	 ?>
	 <?php
	//Products Form
	include_once("./templates/products.php");
	 ?>
	<?php
	//Update Profile Form
	include_once("./templates/update_profile.php");
	?>
	<?php
	  //Change Profile Password Form
	  include_once("./templates/change_profile_password.php");
	?>

<br/>
</body>
</html>