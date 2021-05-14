<?php
return [
	
	'ajax-user-details-json' => [
		'route_value' => '/ajax/user-details/json',
		'auth_check_requirements' => 'none',
		'page_filename' => 'index',
		'redirect_to' => '',
		'route_type' => 'ajax',
		'allowed_request_methods' => ['GET'],
                'controller_type' => 'oop-mapped',
                'controller_class_name' => \EaseAppPHP\EABlueprint\App\Http\Controllers\AllUserDetails\GetController::class,
                'method_name' => 'ajaxJsonOutput',
                'with_middleware' => '',
                'without_middleware' => ''
	],
	'ajax-user-details-xml' => [
		'route_value' => '/ajax/user-details/xml',
		'auth_check_requirements' => 'none',
		'page_filename' => 'index',
		'redirect_to' => '',
		'route_type' => 'ajax',
		'allowed_request_methods' => ['GET'],
                'controller_type' => 'oop-mapped',
                'controller_class_name' => \EaseAppPHP\EABlueprint\App\Http\Controllers\AllUserDetails\GetController::class,
                'method_name' => 'ajaxXmlOutput',
                'with_middleware' => '',
                'without_middleware' => ''
	],
	'ajax-user-details-html' => [
		'route_value' => '/ajax/user-details/html',
		'auth_check_requirements' => 'none',
		'page_filename' => 'index',
		'redirect_to' => '',
		'route_type' => 'ajax',
		'allowed_request_methods' => ['GET'],
                'controller_type' => 'oop-mapped',
                'controller_class_name' => \EaseAppPHP\EABlueprint\App\Http\Controllers\AllUserDetails\GetController::class,
                'method_name' => 'ajaxHtmlOutput',
                'with_middleware' => '',
                'without_middleware' => ''
	],
	'ajax-user-details-text' => [
		'route_value' => '/ajax/user-details/text',
		'auth_check_requirements' => 'none',
		'page_filename' => 'index',
		'redirect_to' => '',
		'route_type' => 'ajax',
		'allowed_request_methods' => ['GET'],
                'controller_type' => 'oop-mapped',
                'controller_class_name' => \EaseAppPHP\EABlueprint\App\Http\Controllers\AllUserDetails\GetController::class,
                'method_name' => 'ajaxTextOutput',
                'with_middleware' => '',
                'without_middleware' => ''
	],

];