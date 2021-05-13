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
        
		$getModel = new Get($this->config, $this->matchedRouteDetails, $this->queryParams);
		
		$dataObject = $getModel->index();
		
		$viewPageFileName = $dataObject->routeRelTemplateFolderPathPrefix . "/" . $this->createViewFileNameWithPath($this->matchedRouteDetails["page_filename"]) . ".php";
		
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
		
		$data = array("name"=>"srirama","place"=>"ayodhya"); 
		/*  $data = new \stdClass;
		$data->name = "srirama";
		$data->place ="ayodhya";  */
		
		$result = $this->response->setJson($data, 200);
		
		//$result = $this->response->setEmpty(204);
		
		return $result;
		
    }
    
    

    
}