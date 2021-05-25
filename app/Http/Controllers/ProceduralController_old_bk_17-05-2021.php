<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Controllers;

use Illuminate\Container\Container;

use \EaseAppPHP\EABlueprint\App\Models\AllUserDetails\Get;

use \EaseAppPHP\Foundation\BaseWebView;

class ProceduralController extends \EaseAppPHP\EABlueprint\App\Http\Controllers\WebController
{
    
    /**
     * Process Ajax/API Call
     *
     * @return array
     */
    public function processAjaxApiCall($pageRouteType, $pageFilename)
    {
        if ($pageRouteType == "ajax") {

                //Pure Ajax Call Scenario
                include "ajax-pages/" . "ajax-header.php";
                include "ajax-pages/" . $pageFilename;

        } elseif ($pageRouteType == "soap-web-service") {

                //Soap Web Service Endpoint Scenario
                include "soap-apis/" . "web-service-endpoint-header.php";
                include "soap-apis/" . $pageFilename;

        } elseif ($pageRouteType == "rest-web-service") {

                //Rest Web Service Endpoint Scenario
                include "rest-apis/" . "web-service-endpoint-header.php";
                include "rest-apis/" . $pageFilename;

        } else {

                //Either Ajax Call or Web Service Endpoint Scenario (Common for BOTH)
                include "ajax-common/" . $pageFilename;

        }
    }
    
    /**
     * Process Web Call
     *
     * @return array
     */
    public function processWebCall($pageRouteType, $routeRelTemplateContext, $chosenTemplateName, $chosenFrontendTemplateName, $pageFilename)
    //public function processWebCall($pageRouteType, $templateName, $pageFilename)
    {
        //Web Applications: This does the loading of the Modal Aspect (logic with db interaction) respective resource for regular web application requests. 
        //Values include: (frontend-web-app | backend-web-app | web-app-common). Note: $config["route_rel_template_context"] or $routeRelTemplateContext will have to be defined in model file, for routes with route-type = web-app-common.
        include "../app/core/model.php";

        if (($pageRouteType == "frontend-web-app") || ($pageRouteType == "backend-web-app") || (($pageRouteType == "web-app-common") && (($routeRelTemplateContext == "frontend") || ($routeRelTemplateContext == "backend")))) {

                //Web Applications: This does the loading of the View Aspect (Template and Page Content with corresponding Assets) respective resource for regular web application requests

                //Include Header
                if (($pageRouteType == "frontend-web-app") || (($pageRouteType == "web-app-common") && ($routeRelTemplateContext == "frontend"))) {

                        //frontend related page / template to be loaded
                        include "templates/" . $chosenFrontendTemplateName . "/header-top.php";
                        include "../app/core/additional-config.php";
                        include "templates/" . $chosenFrontendTemplateName . "/header.php"; 
                        
                        include "templates/" . $chosenFrontendTemplateName . "/" . $pageFilename;

                } elseif (($pageRouteType == "backend-web-app") || (($pageRouteType == "web-app-common") && ($routeRelTemplateContext == "backend"))) {

                        //admin related pages / template to be loaded
                        include "templates/" . $chosenTemplateName . "/header-top.php";
                        include "../app/core/additional-config.php";
                        include "templates/" . $chosenTemplateName . "/header.php";  
                        
                        include "templates/" . $chosenTemplateName . "/" . $pageFilename;

                }

                //include "../app/core/view.php";
                //include "templates/" . $templateName . "/" . $pageFilename;

                //Include Footer
                if (($pageRouteType == "frontend-web-app") || (($pageRouteType == "web-app-common") && ($routeRelTemplateContext == "frontend"))) {

                        //frontend related page / template to be loaded
                        include "templates/" . $chosen_frontend_template . "/footer.php";

                } elseif (($pageRouteType == "backend-web-app") || (($pageRouteType == "web-app-common") && ($routeRelTemplateContext == "backend"))) {

                        //admin related pages / template to be loaded
                        include "templates/" . $chosenTemplateName . "/footer.php";

                }

        }
    }

    
}