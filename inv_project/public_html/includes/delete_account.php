<?php
include_once("../database/constants.php");
include_once("user.php");
include_once("DBOperation.php");
include_once("manage.php");

	if (isset($_GET['token'])) {
		$user = new User();
		$result = $user->tokenExists($_GET['token']);
		if ($result) {
			if (isset($_SESSION["userid"])) {
				$obj = new DBOperation();
				$rows = $obj->getAllRecord("invoice");
				foreach ($rows as $row) {
					if ($row["user_id"] == $_SESSION["userid"]) {
						//unlink("C:xampp\htdocs\inv_project\public_html\PDF_INVOICE\PDF_INVOICE_".$row["invoice_no"].".pdf");
						unlink("..\PDF_INVOICE\PDF_INVOICE_".$row["invoice_no"].".pdf");
					}
				}
				$m = new Manage();
				$m->deleteOrderRecord("invoice_details","user_id",$_SESSION["userid"]);
				$m->deleteOrderRecord("invoice","user_id",$_SESSION["userid"]);
				$m->deleteProfileRecord("products","user_id",$_SESSION["userid"]);
				$m->deleteProfileRecord("brands","user_id",$_SESSION["userid"]);
				$m->deleteProfileRecord("categories","user_id",$_SESSION["userid"]);
				$user = new User();
				$result = $user->deleteUserId($_GET['token']);
				echo $result;
				exit();
			}else{
				?>
				<script type="text/javascript">
					//window.location.href = encodeURI("http://localhost/inv_project/public_html/index.php?msg=First of all login your account..! Then you can delete your account permanently.");
					window.location.href = encodeURI("../index.php?msg=First of all login your account..! Then you can delete your account permanently.");
				</script>
				<?php
			}


			
		}else{
			header("location:".DOMAIN."/");
		}	
	}else{
		header("location:".DOMAIN."/");
	}
?>