<?php
//use \Laminas\Diactoros\Response\RedirectResponse;


/* 
$data = new StdClass;
//$data->routeRelTemplateContext and $data->routeRelTemplateFolderPathPrefix to be defined for web applications with route_type = frontend-web-app | backend-web-app | web-app-common
if ($this->matchedRouteDetails["route_type"] == "frontend-web-app") {
	
	$data->routeRelTemplateContext = "frontend";
	$data->routeRelTemplateFolderPathPrefix = $this->config["mainconfig"]["route_rel_templates_folder_path_prefix"] . '/' . $this->config["mainconfig"]["chosen_frontend_template"];			
	
} elseif ($this->matchedRouteDetails["route_type"] == "backend-web-app") {
	
	$data->routeRelTemplateContext = "backend";
	$data->routeRelTemplateFolderPathPrefix = $this->config["mainconfig"]["route_rel_templates_folder_path_prefix"] . '/' . $this->config["mainconfig"]["chosen_template"];
	
} else {
	
	//$data->routeRelTemplateContext and $data->routeRelTemplateFolderPathPrefix to be defined
	
} */

//echo "<pre>";
//print_r($this->session->all());
//echo "session id: " . $this->session->getId() . "<br>";

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