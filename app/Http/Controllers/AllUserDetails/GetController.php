<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Controllers\AllUserDetails;

use \EaseAppPHP\EABlueprint\App\Models\AllUserDetails\Get;

use \EaseAppPHP\Foundation\BaseWebView;

class GetController extends \EaseAppPHP\EABlueprint\App\Http\Controllers\WebController
{
    
    /**
     * Process Ajax/API Call
     *
     * @return array
     */
    public function index()
    {
        //echo "Welcome to EaseApp OOP";
		$getModel = new Get($this->matchedRouteDetails, $this->queryParams);
		//echo $getModel->index() . "\n";
		$dataArray = $getModel->index();
		//print_r($parametersArray);
		print_r($this->eaConfig);
		echo "\n";
		print_r($this->matchedRouteDetails);
		echo "\n";
		print_r($this->queryParams);
		echo "\n";
		
		$filename = "myfile.php";
		//$dataArray = array("name" => "srirama", "place" => "ayodhya");
		
		$getView = new BaseWebView($filename, $dataArray);
		
		$getView->render();
		
    }
    
    

    
}