<?php
define("PATH_CORE_CLASSES",          PATH_CORE . "classes". DS);
define("PATH_CORE_VIEW",             PATH_CORE_CLASSES . "view". DS);
define("PATH_CORE_ELEMENTS",         PATH_CORE_VIEW . "elements". DS); //re-useble elements
define("PATH_CORE_BASETEMPLATES",    PATH_CORE_VIEW . "basetemplates". DS); //Basepages or layouts

define("PATH_CORE_CONTROLLER",       PATH_CORE_CLASSES . "controller" . DS);
define("PATH_CORE_MODEL",            PATH_CORE_CLASSES . "model" . DS);

define("PATH_CORE_HELPERS",          PATH_APP . "helpers" . DS);
define("PATH_CORE_FACTORIES",        PATH_APP . "factories" . DS);

//ASSET LOCATIONS
define("PATH_CORE_ASSETS",           PATH_CORE ."assets". DS);
define("PATH_CORE_CSS",              PATH_CORE_ASSETS."css". DS);
define("PATH_CORE_JS",               PATH_CORE_ASSETS."js". DS);
define("PATH_CORE_IMG",              PATH_CORE_ASSETS."img". DS);
define("PATH_CORE_JAVA",             PATH_CORE_ASSETS."java". DS);
define("PATH_CORE_FLASH",            PATH_CORE_ASSETS."flash". DS);

define("PATH_CORE_PACKAGES",         PATH_CORE_ASSETS . "packages" . DS);

//URL SETTINGS
define("URL_CORE_ASSETS",           "coreassets/");
define("URL_CORE_CSS",              URL_CORE_ASSETS."css/");
define("URL_CORE_JS",               URL_CORE_ASSETS."js/");
define("URL_CORE_IMG",              URL_CORE_ASSETS."img/");
define("URL_CORE_PACKAGES",         URL_CORE_ASSETS."packages/");

class Loader
{
    static function load()
    {    
        try
        {
            $classes = array(
                    PATH_CORE .     "routing/router.php",
                    PATH_CORE .     "view/template.php",
                    PATH_CORE .     "auth/password.php",
                    PATH_CORE .     "auth/listmodels.php",
                    PATH_CORE .     "auth/session.php",
                    PATH_CORE .     "routing/request.php",
                    PATH_CORE .     "registry/registry.php",
                    PATH_CORE .     "database/IC/DB.php",
                    PATH_CORE .     "classes/controller/core_controller.php",
                    PATH_CORE .     "classes/model/core_model.php",
            );

            /**
            * Loop through list and require each once
            **/
            foreach ($classes as $file) {
                    require_once $file;
            }
            
            /*
             * Loop through all core models/controllers.
             */
            require_once PATH_CORE.'load'.DS.'load_controllers.php';
            require_once PATH_CORE.'load'.DS.'load_models.php';            
            
            $Registry = Registry::getInstance();		

            /**
            * Initialize database link
            **/

            $DB = Database::load(DB_DBMS, DB_HOST, DB_USER, DB_PSWD, DB_BASE);
            $Registry->DB = $DB;

            /**
            * Initialize session instance
            **/
            
           $Session = Session::getInstance()
                    ->setName(SESSION_NAME)
                    ->setLifetime(SESSION_LIFETIME)
                    ->start();
            
            //$Session = new Session('zipcook');
            $Registry->Session = $Session;

            /**
                * Initialize template instance
                */
            $Template = new Template();
            $Template->setPath( array('app'=> PATH_VIEW, 'core'=>PATH_CORE_VIEW), 
                                array('app'=> PATH_ELEMENTS, 'core'=>PATH_CORE_ELEMENTS),
                                array('app'=> PATH_BASETEMPLATES, 'core'=>PATH_CORE_BASETEMPLATES));
            $Template->setCachePath(PATH_CACHE);
            $Registry->Template = $Template;
			
            /**
            * Fire up router
            **/
            
            
            $Router = new Router();
            $Registry->Router = $Router;
            $Router->setPath(PATH_CONTROLLER);
                   //->addRoutes($ROUTES);

            /**
             * Route request!
             **/

            if ($Router->route() === FALSE) {
            /**
            * Rollback just in case, if route was not found
            */
                header(" ", true, 404);
                exit;
            }

            exit;
    /**
        * End of try block
        */
    }

    /**
        * Catch all Exceptions
        */
    catch (Exception $e) {

            /**
                * Don't commit changes.
                */
            //$DB->exec("ROLLBACK");

            /**
                * See if Template instance is initialized and request was not through Ajax method.
                */
            if (isset($Template) && !Request::isAjax()) {

                    /**
                        * Try to render the default exception template page.
                        */
                    try {
                            echo $Template
                                    ->clear()
                                    ->set("exception", $e)
                                    ->render("exception.php");
                            exit;
                    } catch(Exception $x) {}
            }

            /**
                * Render exception as plain text.
                */
            header("Content-Type: text/plain");
            exit($e);
        }
    }
    
    static function loadModel($model_name){
        $done=false;
        
        if(is_readable(PATH_MODEL.$model_name.'_model.php'))
        {
           require_once(PATH_MODEL.$model_name.'_model.php');
           $done=true;
        }
 
        if(is_readable(PATH_CORE_MODEL.$model_name.'_model.php') && $done===false)
        {
           require_once(PATH_CORE_MODEL.$model_name.'_model.php');
           $done=true;
        }
    }
}
