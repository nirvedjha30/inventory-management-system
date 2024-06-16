<?php
include_once("../database/constants.php");
//$DOMAIN = "http://localhost/inv_project/public_html";
$DOMAIN = DOMAIN;
/**
* User Class for account creation and login pupose
*/
class User
{
	
	private $con;

	function __construct()
	{
		include_once("../database/db.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	//User is already registered or not
	private function emailExists($email){
		$pre_stmt = $this->con->prepare("SELECT id FROM user WHERE email = ? ");
		$pre_stmt->bind_param("s",$email);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}

	//User token is already exists or not
	public function tokenExists($token){
		$pre_stmt = $this->con->prepare("SELECT id FROM user WHERE token = ? ");
		$pre_stmt->bind_param("s",$token);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}

	public function createUserAccount($username,$email,$password,$usertype){
		global $DOMAIN;
		//To protect your application from sql attack you can user 
		//prepares statment
		if ($this->emailExists($email)) {
			return "EMAIL_ALREADY_EXISTS";
		}else{
			$pass_hash = password_hash($password,PASSWORD_BCRYPT,["cost"=>8]);
			date_default_timezone_set('Asia/Kolkata');
			$date = date("Y-m-d");
			$token = bin2hex(random_bytes(15));
			$status = 2;
			$notes = "";
			$pre_stmt = $this->con->prepare("INSERT INTO `user`(`username`, `email`, `password`, `usertype`, `register_date`, `last_login`, `token`, `status`, `notes`)
			 VALUES (?,?,?,?,?,?,?,?,?)");
			$pre_stmt->bind_param("sssssssis",$username,$email,$pass_hash,$usertype,$date,$date,$token,$status,$notes);
			$result = $pre_stmt->execute() or die($this->con->error);
			if ($result) {

				//-------------Verify_Email_Address----------
				$subject = "Email Activation for Inventory Management System account creation.";
				//$body = "Hi, $username Click here to activate your account http://localhost/inv_project/public_html/includes/activate.php?token=$token";
				$body = "Hi, $username Click here to activate your account $DOMAIN/includes/activate.php?token=$token";
				$sender_email = "From: nirvedj2023@gmail.com";

				if (mail($email, $subject, $body, $sender_email)) {
				    return $this->con->insert_id;
				} else {
				    echo "Email sending failed...";
				}
				//------------END_Verify_Email-Address----------
			}else{
				return "SOME_ERROR";
			}
		}
			
	}

	public function updateUserAccount($username,$email,$usertype){
		global $DOMAIN;
		//To protect your application from sql attack you can user 
		//prepares statment
		if ($this->emailExists($email)) {
			if ($email != $_SESSION["email"]) {
				return "EMAIL_ALREADY_EXISTS";
			}else{
				$pre_stmt = $this->con->prepare("UPDATE `user` SET `username` = ?, `email` = ?, `usertype` = ? WHERE `id` = ?");
				$pre_stmt->bind_param("sssi",$username,$email,$usertype,$_SESSION["userid"]);
				$result = $pre_stmt->execute() or die($this->con->error);
				if ($result) {
					return $this->con->insert_id;
				}else{
					return "SOME_ERROR";
				}
			}
		}else{
			$token = bin2hex(random_bytes(15));
			$status = 2;
			$pre_stmt = $this->con->prepare("UPDATE `user` SET `username` = ?, `email` = ?, `usertype` = ?, `token` = ?, `status` = ? WHERE `id` = ?");
			$pre_stmt->bind_param("ssssii",$username,$email,$usertype,$token,$status,$_SESSION["userid"]);
			$result = $pre_stmt->execute() or die($this->con->error);
			if ($result) {
				//-------------Verify_Email_Address----------
				$subject = "Email Activation for Inventory Management System Account Updation.";
				//$body = "Hi, $username Click here to activate your account http://localhost/inv_project/public_html/includes/activate.php?token=$token";
				$body = "Hi, $username Click here to activate your account $DOMAIN/includes/activate.php?token=$token";
				$sender_email = "From: nirvedj2023@gmail.com";

				if (mail($email, $subject, $body, $sender_email)) {
					session_destroy();
					return "EMAIL_CHANGE";
				} else {
				    echo "Email sending failed...";
				}
				//------------END_Verify_Email-Address----------
			}else{
				return "SOME_ERROR";
			}
		}
	}


	public function sessionUpdateUserAccount($email){
		$pre_stmt = $this->con->prepare("SELECT * FROM user WHERE email = ?");
		$pre_stmt->bind_param("s",$email);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();

		$row = $result->fetch_assoc();

		$_SESSION["userid"] = $row["id"];
		$_SESSION["username"] = $row["username"];
		$_SESSION["email"] = $row["email"];
		$_SESSION["password"] = $row["password"];
		$_SESSION["usertype"] = $row["usertype"];
	}


	public function updateUserAccountPassword($email,$password,$new_password){
		$pre_stmt = $this->con->prepare("SELECT id,email,password FROM user WHERE email = ?");
		$pre_stmt->bind_param("s",$email);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();

			$row = $result->fetch_assoc();
			if (password_verify($password,$row["password"])) {
				$pass_hash = password_hash($new_password,PASSWORD_BCRYPT,["cost"=>8]);
				$pre_stmt = $this->con->prepare("UPDATE `user` SET `password` = '".$pass_hash."' WHERE `id` = '".$_SESSION["userid"]."' AND `email` = '".$email."' ");
				$result = $pre_stmt->execute() or die($this->con->error);
				if ($result) {
					session_destroy();
					return $this->con->insert_id;
				}else{
					return "SOME_ERROR";
				}

			}else{
				return "PASSWORD_NOT_MATCHED";
			}
	}


	public function userLoginActivate($token){
		$status = 1;
		$pre_stmt = $this->con->prepare("UPDATE user SET status = ? WHERE token = ?");
		$pre_stmt->bind_param("is",$status,$token);
		$result = $pre_stmt->execute() or die($this->con->error);
		if ($result) {
			?>
				<script type="text/javascript">
					//window.location.href = encodeURI("http://localhost/inv_project/public_html/index.php?msg=Your account is activate..! Now you can login.");
					window.location.href = encodeURI("../index.php?msg=Your account is activate..! Now you can login.");
				</script>
			<?php
		}else{
			?>
			<script type="text/javascript">
				window.location.href = encodeURI("../index.php?msg=Your account is not activate..!");
			</script>
			<?php
		}
	}


	public function userLogin($email,$password){
		$pre_stmt = $this->con->prepare("SELECT * FROM user WHERE email = ?");
		$pre_stmt->bind_param("s",$email);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();

		if ($result->num_rows < 1) {
			return "NOT_REGISTERD";
		}else{
			$row = $result->fetch_assoc();
			if ($row["status"] == 1) {
				if (password_verify($password,$row["password"])) {
					$_SESSION["userid"] = $row["id"];
					$_SESSION["username"] = $row["username"];
					$_SESSION["email"] = $row["email"];
					$_SESSION["password"] = $row["password"];
					$_SESSION["usertype"] = $row["usertype"];
					$_SESSION["register_date"] = $row["register_date"];
					$_SESSION["last_login"] = $row["last_login"];

					//Here we are updating user last login time when he is performing login
					date_default_timezone_set('Asia/Kolkata');
					$last_login = date("Y-m-d H:i:s");
					$pre_stmt = $this->con->prepare("UPDATE user SET last_login = ? WHERE email = ?");
					$pre_stmt->bind_param("ss",$last_login,$email);
					$result = $pre_stmt->execute() or die($this->con->error);
					if ($result) {
						return 1;
					}else{
						return 0;
					}

				}else{
					return "PASSWORD_NOT_MATCHED";
				}

			}else{
				return "ACCOUNT_NOT_ACTIVATE";
			}
			
		}
	}


	public function recoverUserAccount($email){
		global $DOMAIN;
		$pre_stmt = $this->con->prepare("SELECT * FROM user WHERE email = ?");
		$pre_stmt->bind_param("s",$email);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();

		if ($result->num_rows < 1) {
			return "NOT_REGISTERD";
		}else{
			$row = $result->fetch_assoc();

			$username = $row["username"];
			$token = bin2hex(random_bytes(15));
			$pre_stmt = $this->con->prepare("UPDATE `user` SET `token` = ? WHERE `email` = ?");
			$pre_stmt->bind_param("ss",$token,$email);
			$result = $pre_stmt->execute() or die($this->con->error);
			if ($result) {
				//-------------Verify_Email_Address----------
				$subject = "Password Reset for Inventory Management System Account.";
				//$body = "Hi, $username Click here to Reset your Account Password http://localhost/inv_project/public_html/reset_password.php?token=$token";
				$body = "Hi, $username Click here to Reset your Account Password $DOMAIN/reset_password.php?token=$token";
				$sender_email = "From: nirvedj2023@gmail.com";

				if (mail($email, $subject, $body, $sender_email)) {
					return "EMAIL_VERIFY";
				} else {
				    echo "Email sending failed...";
				}
				//------------END_Verify_Email-Address----------
			}else{
				return "SOME_ERROR";
			}
			
		}
	}


	public function resetUserAccountPassword($token,$password){
		if ($token == "") {
			return "TOKEN_NOT_FOUND";
		}else{
			$pre_stmt = $this->con->prepare("SELECT id,token,email FROM user WHERE token = ?");
			$pre_stmt->bind_param("s",$token);
			$pre_stmt->execute() or die($this->con->error);
			$result = $pre_stmt->get_result();

			if ($result->num_rows < 1) {
				return "TOKEN_NOT_FOUND";
			}else{
				$row = $result->fetch_assoc();

				$pass_hash = password_hash($password,PASSWORD_BCRYPT,["cost"=>8]);
				$token = bin2hex(random_bytes(15));
				$email = $row["email"];
				$pre_stmt = $this->con->prepare("UPDATE `user` SET `password` = ?, `token` = ? WHERE `email` = ?");
				$pre_stmt->bind_param("sss",$pass_hash,$token,$email);
				$result = $pre_stmt->execute() or die($this->con->error);
				if ($result) {
					return "PASSWORD_UPDATED";
				}else{
					return "SOME_ERROR";
				}
			}
		}		
	}


	public function deleteUserIdVerify($email,$password){
		global $DOMAIN;
		$pre_stmt = $this->con->prepare("SELECT id,email,password FROM user WHERE email = ?");
		$pre_stmt->bind_param("s",$email);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();

			$row = $result->fetch_assoc();
			if (password_verify($password,$row["password"])) {

				$username = $_SESSION["username"];
				$token = bin2hex(random_bytes(15));
				$pre_stmt = $this->con->prepare("UPDATE `user` SET `token` = ? WHERE `id` = ?");
				$pre_stmt->bind_param("si",$token,$_SESSION["userid"]);
				$result = $pre_stmt->execute() or die($this->con->error);
				if ($result) {
					//-------------Verify_Email_Address----------
					$subject = "Email Verify for Inventory Management System Account Permanently DELETED.";
					//$body = "Hi, $username Click here to Permanently DELETE your account http://localhost/inv_project/public_html/includes/delete_account.php?token=$token";
					$body = "Hi, $username Click here to Permanently DELETE your account $DOMAIN/includes/delete_account.php?token=$token";
					$sender_email = "From: nirvedj2023@gmail.com";

					if (mail($email, $subject, $body, $sender_email)) {
						return "EMAIL_VERIFY";
					} else {
					    echo "Email sending failed...";
					}
					//------------END_Verify_Email-Address----------
				}else{
					return "SOME_ERROR";
				}
			}else{
				return "PASSWORD_NOT_MATCHED";
			}
	}


	public function deleteUserId($token){
		$pre_stmt = $this->con->prepare("DELETE FROM `user` WHERE `id` = '".$_SESSION["userid"]."' AND `token` = '".$token."' ");
		$result = $pre_stmt->execute() or die($this->con->error);
		if ($result) {
			session_destroy();
			?>
				<script type="text/javascript">
					window.location.href = encodeURI("../index.php?msg=Your account is Permanently DELETED Successfully..! happy");
				</script>
			<?php
		}else{
			?>
				<script type="text/javascript">
					window.location.href = encodeURI("../profile.php?msg=Your account is not DELETED..!");
				</script>
			<?php
		}
	}

}

//$user = new User();
//echo $user->createUserAccount("Test","nirvedj20231@gmail.com","Nirved@123","Admin");

//echo $user->userLogin("nirvedj20231@gmail.com","Nirved@123");

//echo $_SESSION["username"];
?>