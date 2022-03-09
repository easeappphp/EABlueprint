<?php

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
	
}
			
$data->name = "EaseApp";
$this->session->set('license', 'MIT');
$data->license = $this->container->get('\Odan\Session\PhpSession')->get('license');
//echo "ses: " . $ses . "<br>";exit;
?>