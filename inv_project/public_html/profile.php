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
 	<script type="text/javascript" rel="stylesheet" src="./js/main.js"></script>
 </head>
<body>
<div class="overlay"><div class="loader"></div></div>
	<!-- Navbar -->
	<?php include_once("./templates/header.php"); ?>
	<br/><br/>
	<div class="container">
		<?php
			if (isset($_GET["msg"]) AND !empty($_GET["msg"])) {
				?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
					  <?php echo $_GET["msg"]; ?>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				<?php
			}
		?>
		<div class="card mx-auto" style="width: 25rem; box-shadow:0 0 25px 0 lightgrey;">
	        <div class="card-header" style="text-align:center;"><h4><b>Your Profile</b></h4></div>
	        <img class="card-img-top mx-auto" style="width:60%;" src="./images/user.png" alt="Card image cap">
		      <div class="card-body">
		        <h4 class="card-title">Profile Information</h4>
				    <p class="card-text"><i class="fa fa-user">&nbsp;</i>Name : <?php echo $_SESSION["username"]; ?></p>
				    <p class="card-text"><i class="fa fa-envelope">&nbsp;</i>Email Address : <?php echo $_SESSION["email"]; ?></p>
				    <p class="card-text"><i class="fa fa-user">&nbsp;</i>User Type : <?php echo $_SESSION["usertype"]; ?></p>
				    <p class="card-text"><i class="fa fa-calendar">&nbsp;</i>Register Date : <?php echo $_SESSION["register_date"]; ?></p>
				    <p class="card-text"><i class="fa fa-calendar">&nbsp;</i>Last Login : <?php echo $_SESSION["last_login"]; ?></p>
		      </div>
	      <div class="card-footer text-muted">
	      	<a href="#" data-toggle="modal" data-target="#form_delete_profile" class="btn btn-danger btn-sm"><i class="fa fa-trash">&nbsp;</i>Delete Your ID</a>
	      </div>
	    </div>
	</div>

	<?php
	//Delete Profile Form
	include_once("./templates/delete_profile.php");
	 ?>
<br/>
</body>
</html>