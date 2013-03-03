<?php

class Loader
{
    static function load()
    {
		try
		{
			$classes = array(
				PATH_CORE .	"router.php",
				PATH_CORE . 	"template.php",
                                PATH_CORE . 	"password.php",
				PATH_CLASSES . 	"controller.php",
				PATH_CORE . 	"session.php",
				PATH_CORE . 	"request.php",
				ROUTER_PATH . 	"controller.php",
			);

			/**
			 * Loop through list and require each once
			 */
			foreach ($classes as $file) {
				require $file;
			}
			$Registry = Registry::getInstance();		

			/**
			 * Initialize database link
			 */
			$DB = Database::load("MySQL");
			$DB->connect(DB_HOST, DB_USER, DB_PSWD, DB_BASE);
			$DB->exec("SET SESSION sql_mode='TRADITIONAL'");
			$DB->exec("START TRANSACTION");
			$DB->debug = DO_DEBUGGING;
			$Registry->DB = $DB;
			
			/**
			 * Initialize session instance
			 */
			$Session = Session::getInstance()
				->setName(SESSION_NAME)
				->setLifetime(SESSION_LIFETIME)
				->start();
			
			/**
			 * Initialize template instance
			 */
			$Template = new Template();
			$Registry->Template = $Template;
			$Template->setPath(VIEW_PATH);
			$Template->setCachePath(TEMPLATE_PATH_CACHE);
			
			require PATH_CFG . "routes.php";			
			/**
			 * Fire up router
			 */
			$Router = new Router();
			$Registry->Router = $Router;
			$Router->setPath(ROUTER_PATH)
				   ->addRoutes($ROUTES);
			
			// }}}
			
			/**
			 * Route request!
			 */
			
			if ($Router->route() === FALSE) {
				/**
				 * Rollback just in case, if route was not found
				 */
			   $DB->exec("ROLLBACK");
			   header(" ", true, 404);
			   exit;
			}
			
			
			/**
			 * Commit all changes before exiting
			 */
			$DB->exec("COMMIT");
			exit;
		/**
		 * End of try block
		 */
		}

		// }}}
		// {{{ Catch block

		/**
		 * Catch all Exceptions
		 */
		catch (Exception $e) {
			
			/**
			 * Don't commit changes.
			 */
			$DB->exec("ROLLBACK");
			
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
}
