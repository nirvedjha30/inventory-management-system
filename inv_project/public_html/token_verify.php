<?php

/**
* Token Class for Token verificatin
*/
class Token
{
	
	private $con;

	function __construct()
	{
		include_once("./database/db.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	//User token is already exists or not
	public function tokenExists($token){
		$pre_stmt = $this->con->prepare("SELECT id FROM user WHERE token = ? ");
		$pre_stmt->bind_param("s",$token);
		$pre_stmt->execute() or die($this->con->error);
		$result = $pre_stmt->get_result();
		if($result->num_rows > 0){
			return 0;
		}else{
			return 1;
		}
	}

}
?>