<?php
return [
	
	'admin-panel-dns-record-types-list' => [
		'route_value' => '/admin-panel/dns-record-types/list',
		'description' => '',
		'status' => 'ON',
		'number_of_records' => '10000',
		'number_of_loops_count' => '2',
		'sleep_time_minimum_seconds' => '2',
		'sleep_time_maximum_seconds' => '2',
		'sleep_interval_definition' => 'min',//min | max | random
		'page_filename' => 'admin-panel-dns-record-types-list.php',
		'route_type' => 'backend-web-app',
		'controller_type' => 'procedural',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Console\Controllers\ProceduralController::class,
		'method_name' => 'webHtmlOutput'
	],
	'admin-panel-adss-ta-udzrr-dns-records-list' => [
		'route_value' => '/admin-panel/app-deployment/app-id/:routing_eng_var_4/switchover-step/:routing_eng_var_6/dns-records/list',
		'description' => '',
		'status' => 'ON',
		'number_of_records' => '10000',
		'number_of_loops_count' => '2',
		'sleep_time_minimum_seconds' => '2',
		'sleep_time_maximum_seconds' => '2',
		'sleep_interval_definition' => 'min',//min | max | random
		'page_filename' => 'admin-panel-adss-ta-udzrr-dns-records-list.php',
		'route_type' => 'backend-web-app',
		'controller_type' => 'procedural',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Console\Controllers\ProceduralController::class,
		'method_name' => 'webHtmlOutput'
	],
	'admin-panel-adss-ta-udzrr-dns-record-add' => [
		'route_value' => '/admin-panel/app-deployment/app-id/:routing_eng_var_4/switchover-step/:routing_eng_var_6/dns-record/add',
		'description' => '',
		'status' => 'ON',
		'number_of_records' => '10000',
		'number_of_loops_count' => '2',
		'sleep_time_minimum_seconds' => '2',
		'sleep_time_maximum_seconds' => '2',
		'sleep_interval_definition' => 'min',//min | max | random
		'page_filename' => 'admin-panel-adss-ta-udzrr-dns-record-add.php',
		'route_type' => 'backend-web-app',
		'controller_type' => 'procedural',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Console\Controllers\ProceduralController::class,
		'method_name' => 'webHtmlOutput'
	],
	
];