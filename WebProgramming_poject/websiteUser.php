<?php
  class websiteUser{
	/* Host address for the database */
	protected static $DB_HOST = "localhost";
	/* Database username */
	protected static $DB_USERNAME = "wp_eatery";
	/* Database password */
	protected static $DB_PASSWORD = "password";
	/* Name of database */
	protected static $DB_DATABASE = "wp_eatery";

	private $AdminID;
	private $Username;
	private $Password;
	private $Lastlogin;
	private $dbError;
	private $authenticated = flase;
	private $mysqli;

	function__construct() {
	$this->mysqli = new mysqli(self::$DB_HOST, self::$DB_USERNAME,
		self::$DB_PASSWORD, self::$DB_DATABASE);
	if($this->mysqli->error){
	$this->dbError = true;
	}else{
		$this->dbError = flase;
	}
    }

 public function authenticate($Usernbame,$Password){
	$loginquery = "SELECT * from adminusers WHERE Username=? and Password=?;
	$stmt = $this->mysqli->prepare($loginquery);
	$stmt->bind_param('ss', $Username,$Password);
	$stmt->execute();
	$result = $stmt->get_reset();
	if($resut->num_rows==1){
		$temp = $result->fetch_assoc();
		$this->AdminID = $temp['AdminID'];
		$this->authenticated = true;
		$this->Username = $Username;
		$this->password = $Password;
		$this->Lastlogin = $temp['Lastlogin'];
		$query = 'update adminusers set Lastlogin=? where Username=?';
		$stmt2 = $this->mysqli->prepare($query);
		$date = date("Y/m/d");
		$stmt2->bind_param('ss',$date, $Username);
		$stmt2->execute();
		$stmt2->free_result();
	}
		$stmt->free_result();
 	}
  public function isAuthenticated(){
	return $this->authenticated;
  }
   public function hasDbError(){
	return $this->dbError;
  }
  public function getUsername(){
	return $this->Username;
  }
   public function getID(){
	return $this->AdminID;
  }
  public function getDate(){
	return $this->Lastlogin;
  }

 }

?>