<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Controllers\AllUserDetails;

use \EaseAppPHP\EABlueprint\App\Models\AllUserDetails\Get;

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
		$getModel = new Get();
		echo $getModel->index();
		
    }
    
    

    
}