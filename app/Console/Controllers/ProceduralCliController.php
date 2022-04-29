<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Console\Controllers;

use \Illuminate\Container\Container;
use \EaseAppPHP\Foundation\BaseCliModel;

class ProceduralCliController extends \EaseAppPHP\EABlueprint\App\Console\Controllers\CliController
{
    
    public function cliTextOutput()
    {
        $data = new \StdClass;
		
		$data->matchedRoutePageFilename = $this->matchedRouteDetails["page_filename"];
		$data->pageFilename = $this->matchedRouteDetails["page_filename"];
		
		//Explode based on slash
		 $seo_url_params = explode('/', $this->argv[1]);

		//Count the number of url params
		$r_e_var_count = count($seo_url_params);

		//Define a URL Param Prefix with 20 iterations to pre-define 20 Routine Engine Variables
		$routing_eng_var_ = "routing_eng_var_";    
		extract($seo_url_params, EXTR_PREFIX_ALL, 'routing_eng_var');
		foreach($seo_url_params as $k => $v)
		{
		$routing_eng_var_.$k = (null !== $$routing_eng_var_.$k) ? trim(filter_var($$routing_eng_var_.$k, FILTER_SANITIZE_STRING)) : '';
		}
		
		$data->app_url = $this->container->get('EAConfig')->getDotSeparatedKeyValue("mainconfig.app_url");
		$data->container = $this->container;
		$data->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
		
		
		$modelPageFileName = $_ENV["APP_BASE_PATH"] . "app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		
		if (file_exists($modelPageFileName)) {
			
			include $modelPageFileName;
			
		}
		clearstatcache();
		
		if ((isset($data->responseStatus)) && (is_int($data->responseStatus))) {
			
			return $data->responseStatus;
			
		} else {
			
			//throw new \Exception("Invalid Output from cliTextOutput method!\n");
			echo "Invalid Output from cliTextOutput method!\n";
			
		}
		
    }
	
}