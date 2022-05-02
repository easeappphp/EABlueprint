<?php
$this->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
$data->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');


$smQuery = "SELECT * FROM `site_members` WHERE `sm_memb_id`=:sm_memb_id";
$sm_values_array = array();
$sm_values_array = array(':sm_memb_id' => '1');

$smQueryResult = $data->dbConn->executeQuery($smQuery, $sm_values_array, "selectSingle");
print_r($smQueryResult);

$smlQuery = "SELECT * FROM `site_members`";
$sml_values_array = array();

$smlQueryResult = $data->dbConn->executeQuery($smlQuery, $sml_values_array, "selectMultiple");
print_r($smlQueryResult);

var_dump($data->matchedRoutePageFilename);
var_dump($data->matchedRouteDetails);
var_dump($data->app_url);
var_dump($data->matchedRouteResponse);
//Provide response
$data->response = "This is response message.";
//$data->responseStatus = SELF::SUCCESS;
$data->responseStatus = \EaseAppPHP\Other\EAConstants::CLI_RESPONSE_SUCCESS;

?>