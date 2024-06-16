<?php
include_once("./database/constants.php");
include_once("token_verify.php");
if (!isset($_GET['token'])) {
	header("location:".DOMAIN."/");
}else{
	//User token is already exists or not
	if (isset($_GET['token'])) {
		$token = new Token();
		$result = $token->tokenExists($_GET['token']);
		if ($result) {
			header("location:".DOMAIN."/");
		}
	}
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
		<div class="card mx-auto" style="width: 25rem; box-shadow:0 0 25px 0 lightgrey;">
	        <div class="card-header" style="text-align:center;"><h5><b>Reset Password</b></h5></div>
		      <div class="card-body">
		        <form id="reset_password_form" onsubmit="return false" autocomplete="off">
		          <div class="form-group">
		          	<?php 
		          		if (isset($_GET['token'])) {
		          	?>
		          		<input type="hidden" class="form-control" name="reset_token" id="reset_token" value="<?php echo $_GET['token'] ?>">
		          	<?php
		          		}else{
		          	?>
		          		<input type="hidden" class="form-control" name="reset_token" id="reset_token" value="">
	          		<?php
		          		}
		          	?>
		            <label for="reset_password1">New Password</label>
		            <input type="password" name="reset_password1" class="form-control"  id="reset_password1" placeholder="Enter New Password">
		            <small id="reset_p1_error" class="form-text text-muted"></small>
		          </div>
		          <div class="form-group">
		            <label for="reset_password2">Re-Enter New Password</label>
		            <input type="password" name="reset_password2" class="form-control"  id="reset_password2" placeholder="Re-Enter New Password">
		            <small id="reset_p2_error" class="form-text text-muted"></small>
		          </div>
		          <button type="submit" name="reset_password" class="btn btn-success"><span class="fa fa-edit"></span>&nbsp;Change Password</button>
		          <span><a href="index.php">Login</a></span>
		        </form>
		      </div>
	      <div class="card-footer text-muted">
	        
	      </div>
	    </div>
	</div>
<br/>
</body>
</html>