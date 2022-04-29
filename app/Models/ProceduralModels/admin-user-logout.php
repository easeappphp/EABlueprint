<?php

if (($this->session->has('loggedin')) && ($this->session->get('loggedin') == "yes")) {
	
	// Clear all session variables
	$this->session->clear();
	$this->session->set('loggedin', 'no');	
	
	// Get all session variables
	//echo "<pre>";
	//print_r($this->session->all());
	//exit;
	
}	
	

		

?>