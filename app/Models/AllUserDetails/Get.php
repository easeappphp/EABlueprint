<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Models\AllUserDetails;


class Get extends \EaseAppPHP\Foundation\BaseWebModel
{
    
    protected $matchedRouteDetails;
	protected $queryParams;

	public function __construct($matchedRouteDetails, $queryParams)
	{
		
		$this->matchedRouteDetails = $matchedRouteDetails;
		$this->queryParams = $queryParams;
		
	}
	
	/**
     * Process Ajax/API Call
     *
     * @return array
     */
    public function index()
    {
        echo "Welcome to EaseApp OOP - MODEL";
		echo "\nINSIDE MODEL:\n";
		print_r($this->matchedRouteDetails);
		echo "\n";
		print_r($this->queryParams);
		echo "\n";
    }
    
    

    
}