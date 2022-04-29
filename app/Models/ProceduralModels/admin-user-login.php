<?php

if ($this->serverRequest->getParsedBody()) {
//if ($_POST) {	
/* 	echo "<pre>";
	print_r($this->serverRequest->getParsedBody());
	exit; */
	$this->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
	$query = "SELECT * FROM `site_members` WHERE `username` =:username";
	$values_array = array();
	$values_array = array(':username' => $this->serverRequest->getParsedBody()["username"]);

	$queryResult = $this->dbConn->executeQuery($query, $values_array, "selectSingle");
	//print_r($queryResult);
	$sm_memb_id = $queryResult["sm_memb_id"];
	$username = $queryResult["username"];
	$password = $queryResult["password"];
	$email = $queryResult["email"];
	$sm_user_type = $queryResult["sm_user_type"];
	$user_data_source = $queryResult["user_data_source"];
	$is_active_status = $queryResult["is_active_status"];
	
	if (password_verify($this->serverRequest->getParsedBody()["password"], $password)) {
		//echo 'Password is valid!';
		
		// Get the current session ID
		//echo "session id before regeneration: " . $this->session->getId() . "<br>";

		$this->session->set('loggedin', 'yes');
		
		$this->session->save();
		
		// Start the session
		$this->session->start();
		
		// Generate a new session ID
		$this->session->regenerateId();
		
		// Get the current session ID
		//echo "session id after regeneration: " . $this->session->getId() . "<br>";
		//echo "loggedin status: " . $this->session->get('loggedin') . "<br>";
		
		//echo $this->session->get('loggedin');
		/* 
		$this->session->set('license', 'MIT');
$data->license = $this->container->get('\Odan\Session\PhpSession')->get('license'); */
		
	} else {
		throw new Exception('Invalid password.');
	}
	
} else {
	//echo "POST NOT SUBMITTED" . "<br>"; exit;
}