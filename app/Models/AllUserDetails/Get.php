<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Models\AllUserDetails;

class Get extends \EaseAppPHP\Foundation\BaseWebModel
{
    
   
	/**
     * Process index method
     *
     * @return array
     */
    public function index()
    {
        
		$this->processedModelResponse->name = "srirama";
		$this->processedModelResponse->place = "ayodhya";
		$this->processedModelResponse->x = "10";
		$this->processedModelResponse->colors = array("red", "green", "blue", "yellow");
		
		$this->processedModelResponse->routeRelTemplateContext = $this->getRouteRelTemplateContext();
		$this->processedModelResponse->routeRelTemplateFolderPathPrefix = $this->getRouteRelTemplateFolderPathPrefix();
		return $this->processedModelResponse;
		
    }
	
	

    
}