<?php
return [
	
	'not-found' => [
		'route_value' => '',
		'port' => '',
		'description' => '',
		'status' => 'ON',
		'number_of_records' => '10000',
		'number_of_loops_count' => '2',
		'sleep_time_minimum_seconds' => '2',
		'sleep_time_maximum_seconds' => '4',
		'sleep_interval_definition' => 'min',//min | max | random
		'page_filename' => 'cron-job-sample.php',
		'route_type' => 'cron-job', //cron-job | message-queue-worker | command
		'controller_type' => 'procedural',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Console\Controllers\ProceduralCliController::class,
		'method_name' => 'cliTextOutput'
	],
	'cron-job-sample' => [
		'route_value' => '/cron-job/sample',
		'port' => '',
		'description' => '',
		'status' => 'ON',
		'number_of_records' => '10000',
		'number_of_loops_count' => '2',
		'sleep_time_minimum_seconds' => '2',
		'sleep_time_maximum_seconds' => '4',
		'sleep_interval_definition' => 'min',//min | max | random
		'page_filename' => 'cron-job-sample.php',
		'route_type' => 'cron-job', //cron-job | message-queue-worker | command
		'controller_type' => 'procedural',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Console\Controllers\ProceduralCliController::class,
		'method_name' => 'cliTextOutput'
	],
	'cron-job-oop-sample' => [
		'route_value' => '/cron-job/oop-sample',
		'port' => '',
		'description' => '',
		'status' => 'ON',
		'number_of_records' => '10000',
		'number_of_loops_count' => '2',
		'sleep_time_minimum_seconds' => '2',
		'sleep_time_maximum_seconds' => '4',
		'sleep_interval_definition' => 'min',//min | max | random
		'page_filename' => '',
		'route_type' => 'cron-job', //cron-job | message-queue-worker | command
		'controller_type' => 'oop-mapped',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Console\Controllers\CliAllUserDetails\GetController::class,
		'method_name' => 'cliTextOutput'
	],
	'message-queue-worker-sample' => [
		'route_value' => '/message-queue-worker/sample',
		'port' => '',
		'description' => '',
		'status' => 'ON',
		'number_of_records' => '1',
		'number_of_loops_count' => '1',
		'sleep_time_minimum_seconds' => '2',
		'sleep_time_maximum_seconds' => '4',
		'sleep_interval_definition' => 'min',//min | max | random
		'page_filename' => 'message-queue-worker-sample.php',
		'route_type' => 'message-queue-worker', //cron-job | message-queue-worker | command
		'controller_type' => 'procedural',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Console\Controllers\ProceduralCliController::class,
		'method_name' => 'cliTextOutput'
	],
	'command-sample' => [
		'route_value' => '/command/sample',
		'port' => '',
		'description' => '',
		'status' => 'ON',
		'number_of_records' => '10000',
		'number_of_loops_count' => '2',
		'sleep_time_minimum_seconds' => '2',
		'sleep_time_maximum_seconds' => '4',
		'sleep_interval_definition' => 'min',//min | max | random
		'page_filename' => 'command-sample.php',
		'route_type' => 'command', //cron-job | message-queue-worker | command
		'controller_type' => 'procedural',
		'controller_class_name' => \EaseAppPHP\EABlueprint\App\Console\Controllers\ProceduralCliController::class,
		'method_name' => 'cliTextOutput'
	],
];