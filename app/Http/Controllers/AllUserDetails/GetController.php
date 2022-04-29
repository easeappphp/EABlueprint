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
     */
    public function index()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$dataObject = $getModel->index();
		
		
		$dataObject->license = $this->container->get('\Odan\Session\PhpSession')->get('license');
		
		//$viewPageFileName = $dataObject->routeRelTemplateFolderPathPrefix . "/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]) . ".php";
		$viewPageFileName = $dataObject->routeRelTemplateFolderPathPrefix . "/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]);
		
		$requestTimer = $this->container->get('\SebastianBergmann\Timer\Timer');
		$duration = $requestTimer->stop();
		//echo "as seconds: " . $duration->asNanoseconds()/1000000000 . "<br>";
		$dataObject->requestTimeInSeconds = $duration->asNanoseconds()/1000000000;
		
		if (file_exists($viewPageFileName)) {
			
			$renderedView = BaseWebView::render($viewPageFileName, $dataObject);
			
		} else {
			
			//View file missing scenario
			$renderedView = BaseWebView::render($viewPageFileName, $dataObject);
			
		}
		clearstatcache();
				
		//$result = $this->response->setText("SriRama", 200);
		
		//$result = $this->response->setHtml($renderedView, 200);
		
		/*  $xml="<note>
		<to>Tove</to>
		<from>Jani</from>
		<heading>Reminder</heading>
		<body>Don't forget me this weekend!</body>
		</note>";
		
		$result = $this->response->setXml($xml, 200); */
		
		//$data = array("name"=>"srirama","place"=>"ayodhya"); 
		/*  $data = new \stdClass;
		$data->name = "srirama";
		$data->place ="ayodhya";  */
		
		//$result = $this->response->setJson($data, 200);
		$result = $this->response->setHtml($renderedView, 200);
		
		$result = $result->withHeader(self::RESPONSEHEADER, $dataObject->requestTimeInSeconds . " seconds");
		
		//$result = $this->response->setEmpty(204);
		
		return $result;
		
    }
	
	public function restApiJsonOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$dataObject = $getModel->json();
		
		$result = $this->response->setJson($dataObject->response, 200);
		
		return $result;
		
    }
	
	public function restApiXmlOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$dataObject = $getModel->xml();
		
		$xml='<?xml version="1.0" encoding="UTF-8"?><note>
		<to>Ram</to>
		<from>Bharat</from>
		<heading>Reminder</heading>
		<body>To return as promised</body>
		</note>';
		
		$result = $this->response->setXml($dataObject->response, 200);
		
		return $result;
		
    }
	
	public function ajaxJsonOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$data = $getModel->json();
		
		if ((isset($data->response)) && ((is_object($data->response)) || (is_array($data->response)))) {
			
			$result = $this->response->setJson($data->response, 200);
			
		}
		
		return $result;
		
    }
    
    public function ajaxXmlOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$data = $getModel->xml();
		
		if ((isset($data->response)) && (is_string($data->response))) {
			
			$result = $this->response->setXml($data->response, 200);
			
		}
		
		return $result;
		
    }
	
	public function ajaxHtmlOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$data = $getModel->html();
		
		if ((isset($data->response)) && (is_string($data->response))) {
			
			$result = $this->response->setHtml($data->response, 200);
			
		}
		
		
		return $result;
		
    }
	
	public function ajaxTextOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$data = $getModel->text();
		
		if ((isset($data->response)) && (is_string($data->response))) {
			
			$result = $this->response->setText($data->response, 200);
			
		}
		
		return $result;
		
    }

    
}