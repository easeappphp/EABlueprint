<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Controllers\AllUserDetails;

use \EaseAppPHP\EABlueprint\app\Models\AllUserDetails\Get;

class GetController extends \EaseAppPHP\Foundation\BaseWebController
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