<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Console\Controllers\CliAllUserDetails;

use Illuminate\Container\Container;

use \EaseAppPHP\EABlueprint\App\Models\CliAllUserDetails\Get;

class GetController extends \EaseAppPHP\EABlueprint\App\Console\Controllers\CliController
{
    
    public function cliTextOutput()
    {
        
		$getModel = new Get($this->container, $this->config, $this->matchedRouteDetails);
		
		$data = $getModel->text();
		
		if ((isset($data->responseStatus)) && (is_int($data->responseStatus))) {
			
			return $data->responseStatus;
			
		} else {
			
			//throw new \Exception("Invalid Output from cliTextOutput method!\n");
			echo "Invalid Output from cliTextOutput method!\n";
			
		}
		
    }

    
}