<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Controllers;

use \Illuminate\Container\Container;
use \EaseAppPHP\Foundation\BaseWebModel;
use \EaseAppPHP\Foundation\BaseWebView;

class ProceduralController extends \EaseAppPHP\EABlueprint\App\Http\Controllers\WebController
{
    
    public function webHtmlOutput()
    {
        $data = new \StdClass;
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
		
		$data->matchedRoutePageFilename = $this->matchedRouteDetails["page_filename"];
		$data->pageFilename = $this->matchedRouteDetails["page_filename"];

		//Get the instance of \Odan\Session\PhpSession
		$this->session = $this->container->get('\Odan\Session\PhpSession');
		
		// You can now use your logger
		$this->container->get('\Monolog\Logger\channel-myLogger')->info("logging done in ProceduralController - ");
		
		
		//Explode based on slash
		$seo_url_params = explode('/', $this->serverRequest->getServerParams()['REQUEST_URI']);

		//Count the number of url params
		$r_e_var_count = count($seo_url_params);

		//Define a URL Param Prefix with 20 iterations to pre-define 20 Routine Engine Variables
		$routing_eng_var_ = "routing_eng_var_";    
		extract($seo_url_params, EXTR_PREFIX_ALL, 'routing_eng_var');
		foreach($seo_url_params as $k => $v)
		{
		$routing_eng_var_.$k = (null !== $$routing_eng_var_.$k) ? trim(filter_var($$routing_eng_var_.$k, FILTER_SANITIZE_STRING)) : '';
		}
		
		$data->serverRequest = $this->container->get('\Laminas\Diactoros\ServerRequestFactory');
		$data->session = $this->container->get('\Odan\Session\PhpSession');
		$data->app_url = $this->container->get('EAConfig')->getDotSeparatedKeyValue("mainconfig.app_url");
		$data->container = $this->container;
		$data->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
		
		include $this->container->get('APP_BASE_PATH') . "app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		
		$viewPageFileName = $data->routeRelTemplateFolderPathPrefix . "/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		
		$requestTimer = $this->container->get('\SebastianBergmann\Timer\Timer');
		$duration = $requestTimer->stop();
		//echo "as seconds: " . $duration->asNanoseconds()/1000000000 . "<br>";
		$data->requestTimeInSeconds = $duration->asNanoseconds()/1000000000;

		if (file_exists($viewPageFileName)) {
			
			$renderedView = BaseWebView::render($viewPageFileName, $data);
			
		} else {
			
			//View file missing scenario
			$renderedView = BaseWebView::render($viewPageFileName, $data);
			
		}
		clearstatcache();
				
		$result = $this->response->setHtml($renderedView, 200);
		
		$result = $result->withHeader(self::RESPONSEHEADER, $data->requestTimeInSeconds . " seconds");
		
		return $result;
		
    }
	
	
	public function restApiJsonOutput()
    {
        $data = new \StdClass;
		
		$data->matchedRoutePageFilename = $this->matchedRouteDetails["page_filename"];
		$data->pageFilename = $this->matchedRouteDetails["page_filename"];

		//Explode based on slash
		$seo_url_params = explode('/', $this->serverRequest->getServerParams()['REQUEST_URI']);

		//Count the number of url params
		$r_e_var_count = count($seo_url_params);

		//Define a URL Param Prefix with 20 iterations to pre-define 20 Routine Engine Variables
		$routing_eng_var_ = "routing_eng_var_";    
		extract($seo_url_params, EXTR_PREFIX_ALL, 'routing_eng_var');
		foreach($seo_url_params as $k => $v)
		{
		$routing_eng_var_.$k = (null !== $$routing_eng_var_.$k) ? trim(filter_var($$routing_eng_var_.$k, FILTER_SANITIZE_STRING)) : '';
		}
		
		$data->serverRequest = $this->container->get('\Laminas\Diactoros\ServerRequestFactory');
		$data->session = $this->container->get('\Odan\Session\PhpSession');
		$data->app_url = $this->container->get('EAConfig')->getDotSeparatedKeyValue("mainconfig.app_url");
		$data->container = $this->container;
		$data->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
		
		
		//$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		$modelPageFileName = $this->container->get('APP_BASE_PATH') . "app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		
		if (file_exists($modelPageFileName)) {
			
			include $modelPageFileName;
			
		}
		clearstatcache();
		
		if ((isset($data->response)) && (is_object($data->response))) {
			
			$result = $this->response->setJson($data->response, 200);
		
			return $result;
			
		} else {
			
			throw new \Exception("Invalid Output from restApiJsonOutput method!\n");
			
		}
		
    }
	
	public function restApiXmlOutput()
    {
        $data = new \StdClass;
		
		$data->matchedRoutePageFilename = $this->matchedRouteDetails["page_filename"];
		$data->pageFilename = $this->matchedRouteDetails["page_filename"];

		//Explode based on slash
		$seo_url_params = explode('/', $this->serverRequest->getServerParams()['REQUEST_URI']);

		//Count the number of url params
		$r_e_var_count = count($seo_url_params);

		//Define a URL Param Prefix with 20 iterations to pre-define 20 Routine Engine Variables
		$routing_eng_var_ = "routing_eng_var_";    
		extract($seo_url_params, EXTR_PREFIX_ALL, 'routing_eng_var');
		foreach($seo_url_params as $k => $v)
		{
		$routing_eng_var_.$k = (null !== $$routing_eng_var_.$k) ? trim(filter_var($$routing_eng_var_.$k, FILTER_SANITIZE_STRING)) : '';
		}
		
		$data->serverRequest = $this->container->get('\Laminas\Diactoros\ServerRequestFactory');
		$data->session = $this->container->get('\Odan\Session\PhpSession');
		$data->app_url = $this->container->get('EAConfig')->getDotSeparatedKeyValue("mainconfig.app_url");
		$data->container = $this->container;
		$data->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
		
		
		/* $xml='<?xml version="1.0" encoding="UTF-8"?><note>
		<to>Ram</to>
		<from>Bharat</from>
		<heading>Reminder</heading>
		<body>To return as promised</body>
		</note>'; */
		
		
		
		//$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		$modelPageFileName = $this->container->get('APP_BASE_PATH') . "app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		
		if (file_exists($modelPageFileName)) {
			
			include $modelPageFileName;
			
		}
		clearstatcache();
		
		if ((isset($data->response)) && (is_string($data->response))) {
			
			$result = $this->response->setXml($data->response, 200);
		
			return $result;
			
		} else {
			
			throw new \Exception("Invalid Output from restApiXmlOutput method!\n");
			
		}
		
    }
	
	public function ajaxJsonOutput()
    {
        $data = new \StdClass;
		
		$data->matchedRoutePageFilename = $this->matchedRouteDetails["page_filename"];
		$data->pageFilename = $this->matchedRouteDetails["page_filename"];

		//Get the instance of \Odan\Session\PhpSession
		$this->session = $this->container->get('\Odan\Session\PhpSession');
		
		//Explode based on slash
		$seo_url_params = explode('/', $this->serverRequest->getServerParams()['REQUEST_URI']);

		//Count the number of url params
		$r_e_var_count = count($seo_url_params);

		//Define a URL Param Prefix with 20 iterations to pre-define 20 Routine Engine Variables
		$routing_eng_var_ = "routing_eng_var_";    
		extract($seo_url_params, EXTR_PREFIX_ALL, 'routing_eng_var');
		foreach($seo_url_params as $k => $v)
		{
		$routing_eng_var_.$k = (null !== $$routing_eng_var_.$k) ? trim(filter_var($$routing_eng_var_.$k, FILTER_SANITIZE_STRING)) : '';
		}
		
		$data->serverRequest = $this->container->get('\Laminas\Diactoros\ServerRequestFactory');
		$data->session = $this->container->get('\Odan\Session\PhpSession');
		$data->app_url = $this->container->get('EAConfig')->getDotSeparatedKeyValue("mainconfig.app_url");
		$data->container = $this->container;
		$data->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
		
		
		//$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		$modelPageFileName = $this->container->get('APP_BASE_PATH') . "app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		
		if (file_exists($modelPageFileName)) {
			
			include $modelPageFileName;
			
		}
		clearstatcache();
		
		if ((isset($data->response)) && ((is_object($data->response)) || (is_array($data->response)))) {
			
			$result = $this->response->setJson($data->response, 200);
			
			return $result;
			
			
		} else {
			
			throw new \Exception("Invalid Output from ajaxJsonOutput method!\n");
			
		}
		
    }
    
    public function ajaxXmlOutput()
    {
        $data = new \StdClass;
		
		$data->matchedRoutePageFilename = $this->matchedRouteDetails["page_filename"];
		$data->pageFilename = $this->matchedRouteDetails["page_filename"];

		//Get the instance of \Odan\Session\PhpSession
		$this->session = $this->container->get('\Odan\Session\PhpSession');
		
		//Explode based on slash
		$seo_url_params = explode('/', $this->serverRequest->getServerParams()['REQUEST_URI']);

		//Count the number of url params
		$r_e_var_count = count($seo_url_params);

		//Define a URL Param Prefix with 20 iterations to pre-define 20 Routine Engine Variables
		$routing_eng_var_ = "routing_eng_var_";    
		extract($seo_url_params, EXTR_PREFIX_ALL, 'routing_eng_var');
		foreach($seo_url_params as $k => $v)
		{
		$routing_eng_var_.$k = (null !== $$routing_eng_var_.$k) ? trim(filter_var($$routing_eng_var_.$k, FILTER_SANITIZE_STRING)) : '';
		}
		
		$data->serverRequest = $this->container->get('\Laminas\Diactoros\ServerRequestFactory');
		$data->session = $this->container->get('\Odan\Session\PhpSession');
		$data->app_url = $this->container->get('EAConfig')->getDotSeparatedKeyValue("mainconfig.app_url");
		$data->container = $this->container;
		$data->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
		
		
		//$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		$modelPageFileName = $this->container->get('APP_BASE_PATH') . "app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		
		if (file_exists($modelPageFileName)) {
			
			include $modelPageFileName;
			
		}
		clearstatcache();
		
		if ((isset($data->response)) && (is_string($data->response))) {
			
			$result = $this->response->setXml($data->response, 200);
		
			return $result;
			
			
		} else {
			
			throw new \Exception("Invalid Output from restApiXmlOutput method!\n");
			
		}
		
    }
	
	public function ajaxHtmlOutput()
    {
        $data = new \StdClass;
		
		$data->matchedRoutePageFilename = $this->matchedRouteDetails["page_filename"];
		$data->pageFilename = $this->matchedRouteDetails["page_filename"];

		//Get the instance of \Odan\Session\PhpSession
		$this->session = $this->container->get('\Odan\Session\PhpSession');
		
		//Explode based on slash
		$seo_url_params = explode('/', $this->serverRequest->getServerParams()['REQUEST_URI']);

		//Count the number of url params
		$r_e_var_count = count($seo_url_params);

		//Define a URL Param Prefix with 20 iterations to pre-define 20 Routine Engine Variables
		$routing_eng_var_ = "routing_eng_var_";    
		extract($seo_url_params, EXTR_PREFIX_ALL, 'routing_eng_var');
		foreach($seo_url_params as $k => $v)
		{
		$routing_eng_var_.$k = (null !== $$routing_eng_var_.$k) ? trim(filter_var($$routing_eng_var_.$k, FILTER_SANITIZE_STRING)) : '';
		}
		
		$data->serverRequest = $this->container->get('\Laminas\Diactoros\ServerRequestFactory');
		$data->session = $this->container->get('\Odan\Session\PhpSession');
		$data->app_url = $this->container->get('EAConfig')->getDotSeparatedKeyValue("mainconfig.app_url");
		$data->container = $this->container;
		$data->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
		
		
		//$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		$modelPageFileName = $this->container->get('APP_BASE_PATH') . "app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		
		if (file_exists($modelPageFileName)) {
			
			$renderedModel = BaseWebModel::renderHtml($modelPageFileName, $data);
			
		}
		clearstatcache();
		
		if (is_string($renderedModel)) {
			
			$result = $this->response->setHtml($renderedModel, 200);
		
			return $result;
			
			
		} else {
			
			throw new \Exception("Invalid Output from ajaxHtmlOutput method!\n");
			
		}
		
    }
	
	public function ajaxTextOutput()
    {
        $data = new \StdClass;
		
		$data->matchedRoutePageFilename = $this->matchedRouteDetails["page_filename"];
		$data->pageFilename = $this->matchedRouteDetails["page_filename"];

		//Get the instance of \Odan\Session\PhpSession
		$this->session = $this->container->get('\Odan\Session\PhpSession');
		
		//Explode based on slash
		$seo_url_params = explode('/', $this->serverRequest->getServerParams()['REQUEST_URI']);

		//Count the number of url params
		$r_e_var_count = count($seo_url_params);

		//Define a URL Param Prefix with 20 iterations to pre-define 20 Routine Engine Variables
		$routing_eng_var_ = "routing_eng_var_";    
		extract($seo_url_params, EXTR_PREFIX_ALL, 'routing_eng_var');
		foreach($seo_url_params as $k => $v)
		{
		$routing_eng_var_.$k = (null !== $$routing_eng_var_.$k) ? trim(filter_var($$routing_eng_var_.$k, FILTER_SANITIZE_STRING)) : '';
		}
		
		$data->serverRequest = $this->container->get('\Laminas\Diactoros\ServerRequestFactory');
		$data->session = $this->container->get('\Odan\Session\PhpSession');
		$data->app_url = $this->container->get('EAConfig')->getDotSeparatedKeyValue("mainconfig.app_url");
		$data->container = $this->container;
		$data->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
		
		
		//$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		$modelPageFileName = $this->container->get('APP_BASE_PATH') . "app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		
		if (file_exists($modelPageFileName)) {
			
			include $modelPageFileName;
			
		}
		clearstatcache();
		
		if ((isset($data->response)) && (is_string($data->response))) {
			
			$result = $this->response->setText($data->response, 200);
		
			return $result;
			
			
		} else {
			
			throw new \Exception("Invalid Output from ajaxTextOutput method!\n");
			
		}
		
		
    }

    
}