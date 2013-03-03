<?php
//Include config files
require_once(PATH_CFG . 'cfg.application.php'); //app confguration
require_once(PATH_CFG . 'cfg.base.config.php'); //base configuration
require_once(PATH_CFG . 'cfg.database.php'); //database config
require_once(PATH_CFG . 'cfg.routes.php'); //local aditional routes
require_once(PATH_CORE . 'load' .DS . 'loader.php'); //load core

set_include_path
(
      PATH_SEPARATOR . ROOT
    . PATH_SEPARATOR . PATH_CORE
    . PATH_SEPARATOR . PATH_APP
    . PATH_SEPARATOR . PATH_CFG
    . PATH_SEPARATOR . PATH_TMP
);

if (ERROR_THROW === true)
{
    function ErrorToException($errno, $errstr, $errfile, $errline)
    {
        throw new ErrorException($errstr, $errno, $errno, $errfile, $errline);
    }
    
    set_error_handler("ErrorToException", ERROR_LEVEL);
}

error_reporting(ERROR_LEVEL);

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