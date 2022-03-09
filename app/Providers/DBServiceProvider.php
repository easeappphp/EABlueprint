<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Providers;

use Illuminate\Container\Container;

use \EaseAppPHP\Foundation\ServiceProvider;

use \EaseAppPHP\PDOLight\PDOLight;

class DBServiceProvider extends ServiceProvider
{
    protected $container;
	
	protected $serverRequest;
	
	protected $dbConn;
	
	//protected $response;
    
     
    /**
     * Create a new Illuminate application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct($container)
    {
        $this->container = $container;
    }   
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
		if ($this->container->get('EARequestConsoleStatusResult') == "Web") {
            
            
        }
		
		$dbHost = $this->container->get('config')["mainconfig"]["connections"]["mysql"]["host"];
		$dbUsername = $this->container->get('config')["mainconfig"]["connections"]["mysql"]["username"];
		$dbPassword = $this->container->get('config')["mainconfig"]["connections"]["mysql"]["password"];
		$dbName = $this->container->get('config')["mainconfig"]["connections"]["mysql"]["database"];
		$charset = "utf8mb4";
		$port = "3306";
		$pdoAttrDefaultFetchMode = \PDO::FETCH_ASSOC; //\PDO::FETCH_ASSOC or \PDO::FETCH_OBJ

		$pdoConn = new PDOLight($dbHost, $dbUsername, $dbPassword, $dbName, $charset, $port, $pdoAttrDefaultFetchMode);
		$this->container->instance('\EaseAppPHP\PDOLight\PDOLight-dbConn', $pdoConn);
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->container->get('EARequestConsoleStatusResult') == "Web") {
                        		
        }
		
		$this->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
		
		
		
		
		$query = "SELECT * FROM `applications`";
		$values_array = array();

		$queryResult = $this->dbConn->executeQuery($query, $values_array, "selectMultiple");
		//print_r($queryResult);
		//exit;
    }
}