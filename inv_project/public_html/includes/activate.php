<?php
include_once("../database/constants.php");
include_once("user.php");

	if (isset($_GET['token'])) {
		$user = new User();
		$result = $user->tokenExists($_GET['token']);
		if ($result) {
			$user = new User();
			$result = $user->userLoginActivate($_GET['token']);
			echo $result;
			exit();
		}else{
			header("location:".DOMAIN."/");
		}
	}else{
		header("location:".DOMAIN."/");
	}
?>