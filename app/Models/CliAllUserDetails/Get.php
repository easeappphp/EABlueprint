<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Models\CliAllUserDetails;

use Illuminate\Container\Container;

class Get extends \EaseAppPHP\Foundation\BaseCliModel
{
    
   /**
     * Process text method
     *
     * @return string
     */
    public function text()
    {
        //Provide response
		$this->processedModelResponse->response = "This is response message.";
		//$this->processedModelResponse->responseStatus = 0;
		$this->processedModelResponse->responseStatus = \EaseAppPHP\Other\EAConstants::CLI_RESPONSE_SUCCESS;

		return $this->processedModelResponse;
		
    }
	 
}