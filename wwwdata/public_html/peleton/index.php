<?php
//Kick-off app.
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);
define('PATH_APP', ROOT . 'app' . DS);
define('PATH_CFG', ROOT . 'cfg' . DS);
define('PATH_CORE', dirname(ROOT). DS . 'core' . DS);

require_once(PATH_CFG . 'loader.php');
//print_r(get_defined_constants());

//include PATH_CORE . 'load'.DS.'loader.php';

//var_dump(PATH_CORE);
//Loader::load();