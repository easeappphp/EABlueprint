<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Controllers;

use Illuminate\Container\Container;

use \EaseAppPHP\EABlueprint\App\Models\AllUserDetails\Get;

use \EaseAppPHP\Foundation\BaseWebModel;

use \EaseAppPHP\Foundation\BaseWebView;

class ProceduralController extends \EaseAppPHP\EABlueprint\App\Http\Controllers\WebController
{
    
    public function webHtmlOutput()
    {
        include "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]) . ".php";
		
		$viewPageFileName = $data->routeRelTemplateFolderPathPrefix . "/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]) . ".php";
		
		if (file_exists($viewPageFileName)) {
			
			$renderedView = BaseWebView::render($viewPageFileName, $data);
			
		} else {
			
			//View file missing scenario
			$renderedView = BaseWebView::render($viewPageFileName, $data);
			
		}
		clearstatcache();
				
		//$result = $this->response->setText("SriRama", 200);
		
		$result = $this->response->setHtml($renderedView, 200);
		
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
		
		//$result = $this->response->setEmpty(204);
		
		return $result;
		
    }
	
	
	public function restApiJsonOutput()
    {
        
		$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]) . ".php";
		
		if (file_exists($modelPageFileName)) {
			
			include $modelPageFileName;
			
		}
		clearstatcache();
		//$data = array("name"=>"srirama","place"=>"ayodhya"); 
		/*  $dataObject = new \stdClass;
		$dataObject->name = "srirama";
		$dataObject->place ="ayodhya";  */
		
		if ((isset($data)) && (is_object($data)) || (is_array($data))) {
			
			$result = $this->response->setJson($data, 200);
		
			return $result;
			
		} else {
			
			throw new \Exception("Invalid Output from restApiJsonOutput method!\n");
			
		}
		
    }
	
	public function restApiXmlOutput()
    {
        
		/* $xml='<?xml version="1.0" encoding="UTF-8"?><note>
		<to>Ram</to>
		<from>Bharat</from>
		<heading>Reminder</heading>
		<body>To return as promised</body>
		</note>'; */
		
		
		
		$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]) . ".php";
		
		if (file_exists($modelPageFileName)) {
			
			include $modelPageFileName;
			
		}
		clearstatcache();
		
		if (is_string($data)) {
			
			$result = $this->response->setXml($data, 200);
		
			return $result;
			
		} else {
			
			throw new \Exception("Invalid Output from restApiXmlOutput method!\n");
			
		}
		
    }
	
	public function ajaxJsonOutput()
    {
        
		$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]) . ".php";
		
		if (file_exists($modelPageFileName)) {
			
			include $modelPageFileName;
			
		}
		clearstatcache();
		
		if ((is_object($data)) || (is_array($data))) {
			
			$result = $this->response->setJson($data, 200);
		
			return $result;
			
		} else {
			
			throw new \Exception("Invalid Output from ajaxJsonOutput method!\n");
			
		}
		
    }
    
    public function ajaxXmlOutput()
    {
        
		$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]) . ".php";
		
		if (file_exists($modelPageFileName)) {
			
			include $modelPageFileName;
			
		}
		clearstatcache();
		
		if (is_string($data)) {
			
			$result = $this->response->setXml($data, 200);
		
			return $result;
			
			
		} else {
			
			throw new \Exception("Invalid Output from restApiXmlOutput method!\n");
			
		}
		
    }
	
	public function ajaxHtmlOutput()
    {
        
		$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]) . ".php";
		
		if (file_exists($modelPageFileName)) {
			
			$renderedModel = BaseWebModel::renderHtml($modelPageFileName);
			
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
        
		$modelPageFileName = "../app/Models/ProceduralModels/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]) . ".php";
		
		if (file_exists($modelPageFileName)) {
			
			include $modelPageFileName;
			
		}
		clearstatcache();
		
		if (is_string($data)) {
			
			$result = $this->response->setText($data, 200);
		
			return $result;
			
			
		} else {
			
			throw new \Exception("Invalid Output from ajaxTextOutput method!\n");
			
		}
		
		
    }

    
}