<?php

define("PATH_LIB",        PATH_FRAME    . "lib/");
define("PATH_TMP",        PATH_FRAME    . "tmp/");
define("PATH_CLASSES",    PATH_FRAME    . "classes/");
define("PATH_HELPERS",    PATH_CLASSES . "helpers/");
define("PATH_FACTORIES",  PATH_CLASSES . "factories/");
define("PATH_MODELS",	  PATH_CLASSES . "models/");
define("PATH_CORE",       PATH_CLASSES . "core/");

set_include_path
(
      PATH_SEPARATOR . PATH_ROOT
    . PATH_SEPARATOR . PATH_FRAME
    . PATH_SEPARATOR . PATH_LIB
    . PATH_SEPARATOR . PATH_HELPERS
    . PATH_SEPARATOR . PATH_CLASSES
    . PATH_SEPARATOR . PATH_FACTORIES
);

require PATH_CFG . "config.php";

if (ERROR_THROW === true)
{
    function ErrorToException($errno, $errstr, $errfile, $errline)
    {
        throw new ErrorException($errstr, $errno, $errno, $errfile, $errline);
    }
    
    set_error_handler("ErrorToException", ERROR_LEVEL);
}

error_reporting(ERROR_LEVEL);

$required = array
(
    PATH_CLASSES . "factory.php",
    PATH_CORE	 . "registry.php",
    PATH_CLASSES . "database.php",
    PATH_CLASSES . "loader.php"
);

foreach ($required as $file)
{
    require $file;
}

function autoloader($classname)
{
    $paths = array
    (
        PATH_CLASSES,
        PATH_HELPERS,
        PATH_FACTORIES,
	PATH_CORE,
	PATH_MODELS
    );

    $file = strtolower($classname . ".php");
    
    foreach ($paths as $path)
    {
        if (file_exists($path.$file))
        {
            require_once $path . $file;
        }
    }
}

spl_autoload_register('autoloader');
Loader::load();
