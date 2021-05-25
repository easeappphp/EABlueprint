<?php
return [
	
	'rest-user-details-api' => [
		'route_value' => '/rest/user-details/api',
		'auth_check_requirements' => 'none',
		'page_filename' => 'index',
		'redirect_to' => '',
		'route_type' => 'rest-web-service',
		'allowed_request_methods' => ['GET'],
		'controller_type' => 'oop-mapped',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Http\Controllers\AllUserDetails\GetController::class,
		'method_name' => 'restApiJsonOutput',
		'with_middleware' => '',
		'without_middleware' => ''
	],
	'rest-user-details-xml-api' => [
		'route_value' => '/rest/user-details/xml-api',
		'auth_check_requirements' => 'none',
		'page_filename' => 'index',
		'redirect_to' => '',
		'route_type' => 'rest-web-service',
		'allowed_request_methods' => ['GET'],
		'controller_type' => 'oop-mapped',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Http\Controllers\AllUserDetails\GetController::class,
		'method_name' => 'restApiXmlOutput',
		'with_middleware' => '',
		'without_middleware' => ''
	],
	'rest-procedural-user-details-api' => [
		'route_value' => '/rest/procedural/user-details/api',
		'auth_check_requirements' => 'none',
		'page_filename' => 'index',
		'redirect_to' => '',
		'route_type' => 'rest-web-service',
		'allowed_request_methods' => ['GET'],
		'controller_type' => 'procedural',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Http\Controllers\ProceduralController::class,
		'method_name' => 'restApiJsonOutput',
		'with_middleware' => '',
		'without_middleware' => ''
	],
	'rest-procedural-user-details-xml-api' => [
		'route_value' => '/rest/procedural/user-details/xml-api',
		'auth_check_requirements' => 'none',
		'page_filename' => 'indexXml',
		'redirect_to' => '',
		'route_type' => 'rest-web-service',
		'allowed_request_methods' => ['GET'],
		'controller_type' => 'procedural',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Http\Controllers\ProceduralController::class,
		'method_name' => 'restApiXmlOutput',
		'with_middleware' => '',
		'without_middleware' => ''
	],

];