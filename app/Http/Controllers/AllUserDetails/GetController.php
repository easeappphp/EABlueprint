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
		
		$dataObject = $getModel->index();
		
		$data = array("name"=>"srirama","place"=>"ayodhya, near Saryu River"); 
		/*  $data = new \stdClass;
		$data->name = "srirama";
		$data->place ="ayodhya";  */
		
		$result = $this->response->setJson($data, 200);
		
		return $result;
		
    }
	
	public function restApiXmlOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$dataObject = $getModel->index();
		
		$xml='<?xml version="1.0" encoding="UTF-8"?><note>
		<to>Ram</to>
		<from>Bharat</from>
		<heading>Reminder</heading>
		<body>To return as promised</body>
		</note>';
		
		$result = $this->response->setXml($xml, 200);
		
		return $result;
		
    }
	
	public function ajaxJsonOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$dataObject = $getModel->index();
		
		$data = array("name"=>"srirama","place"=>"ayodhya"); 
		/*  $data = new \stdClass;
		$data->name = "srirama";
		$data->place ="ayodhya";  */
		
		$result = $this->response->setJson($data, 200);
		
		return $result;
		
    }
    
    public function ajaxXmlOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$dataObject = $getModel->index();
		
		$xml='<?xml version="1.0" encoding="UTF-8"?><note>
		<to>Ram</to>
		<from>Bharat</from>
		<heading>Reminder</heading>
		<body>To return as promised</body>
		</note>';
		
		$result = $this->response->setXml($xml, 200);
		
		return $result;
		
    }
	
	public function ajaxHtmlOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$dataObject = $getModel->index();
		
		$renderedView = "<!DOCTYPE html>
<html>
 <body>
 <h1>Ram</h1>
 <div>Ayodhya</div>
 </body>
</html>";
		
		$result = $this->response->setHtml($renderedView, 200);
		
		return $result;
		
    }
	
	public function ajaxTextOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$dataObject = $getModel->index();
		
		$result = $this->response->setText("SriRama", 200);
		
		return $result;
		
    }

    
}