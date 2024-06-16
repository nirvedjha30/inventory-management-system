<?php

include_once("./database/constants.php");
if (isset($_SESSION["userid"])) {
	session_destroy();
	?>
	<script type="text/javascript">
		//window.location.href = encodeURI("http://localhost/inv_project/public_html/index.php?msg=You have been successfully logged out..! happy.");
		window.location.href = encodeURI("index.php?msg=You have been successfully logged out..! happy.");
	</script>
	<?php
}
// header("location:".DOMAIN."/");

?>