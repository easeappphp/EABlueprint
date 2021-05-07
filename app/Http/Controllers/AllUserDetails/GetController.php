<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Controllers\AllUserDetails;

use Illuminate\Container\Container;

use \EaseAppPHP\EABlueprint\App\Models\AllUserDetails\Get;

use \EaseAppPHP\Foundation\BaseWebView;

class GetController extends \EaseAppPHP\EABlueprint\App\Http\Controllers\WebController
{
    
    /**
     * Process index method
     *
     * @return array
     */
    public function index()
    {
        
		$getModel = new Get($this->eaConfig, $this->matchedRouteDetails, $this->queryParams);
		
		$dataObject = $getModel->index();
		
		$viewPageFileName = $dataObject->routeRelTemplateFolderPathPrefix . "/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]) . ".php";
		
		if (file_exists($viewPageFileName)) {
			
			$getView = new BaseWebView($viewPageFileName, $dataObject);
			
		} else {
			
			$getView = new BaseWebView($viewPageFileName, $dataObject);
			
		}
		clearstatcache();
				
		$renderedResult = $getView->render();
		
		$this->container->instance('ParsedView', $renderedResult);
		
		
		
    }
    
    

    
}