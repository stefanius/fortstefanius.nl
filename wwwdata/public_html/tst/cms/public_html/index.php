<?php

if(!defined('DS')){
   define('DS', DIRECTORY_SEPARATOR); 
}
define('PATH_APP', dirname(dirname(__FILE__)) . DS);
define('PATH_PUBLIC_HTML', PATH_APP . 'public_html' . DS);
define("PATH_ROOT", dirname(PATH_APP) . DS);
define("PATH_CFG", PATH_APP . "cfg/");
define("PATH_FRAME", PATH_APP);
require_once PATH_CFG . "init.php";
