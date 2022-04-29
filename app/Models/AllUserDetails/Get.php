<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Models\AllUserDetails;

use Illuminate\Container\Container;

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
		$this->processedModelResponse->userSessionInfo = $this->container->get('\Odan\Session\PhpSession')->get('bar');
		$this->processedModelResponse->response = array("name"=>"srirama","place"=>"ayodhya"); 
		
		return $this->processedModelResponse;
		
    }
	
	/**
     * Process json method
     *
     * @return array
     */
    public function json()
    {
        
		$this->processedModelResponse->response = array("name"=>"srirama","place"=>"ayodhya","Rajyam"=>"Kosala"); 
		
		return $this->processedModelResponse;
		
    }
	
	/**
     * Process xml method
     *
     * @return string
     */
    public function xml()
    {
        $xml='<?xml version="1.0" encoding="UTF-8"?>
		<note>
		<name>srirama</to>
		<place>ayodhya</from>
		<rajyam>Kosala</heading>
		</note>';
		
		$this->processedModelResponse->response = $xml; 
		
		return $this->processedModelResponse;
		
    }
	
	
	/**
     * Process html method
     *
     * @return string
     */
    public function html()
    {
        $renderedView = "<!DOCTYPE html>
		<html>
		 <body>
		 <h1>Ram</h1>
		 <div>Ayodhya</div>
		 </body>
		</html>";
		
		$this->processedModelResponse->response = $renderedView; 
		
		return $this->processedModelResponse;
		
    }
	
	
	/**
     * Process text method
     *
     * @return string
     */
    public function text()
    {
        $text='SriRama';
		
		$this->processedModelResponse->response = $text; 
		
		return $this->processedModelResponse;
		
    }
	
	

    
}