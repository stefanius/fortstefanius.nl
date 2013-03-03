<?php
//Normally it isnt needed to be changed.
define("ERROR_LEVEL",           E_ERROR);

//APP-PATH SETTINGS
define("PATH_PUBLIC_HTML",      ROOT ."public_html". DS);
define("PATH_VIEW",             PATH_APP . "view". DS);
define("PATH_ELEMENTS",         PATH_VIEW . "elements". DS); //re-useble elements
define("PATH_BASETEMPLATES",    PATH_VIEW . "basetemplates". DS); //Basepages or layouts

define("PATH_CONTROLLER",       PATH_APP . "controller" . DS);
define("PATH_MODEL",            PATH_APP . "model" . DS);

define("PATH_TMP",              PATH_APP . "tmp" . DS);
define("PATH_HELPERS",          PATH_APP . "helpers" . DS);
define("PATH_FACTORIES",        PATH_APP . "factories" . DS);

//ASSET LOCATIONS
define("PATH_ASSETS",           PATH_PUBLIC_HTML."assets". DS);
define("PATH_CSS",              PATH_PUBLIC_HTML."css". DS);
define("PATH_JS",               PATH_PUBLIC_HTML."js". DS);
define("PATH_IMG",              PATH_PUBLIC_HTML."img". DS);

//SESSION - CACHE VARS
define("PATH_CACHE",            PATH_TMP.DS."cache".DS);
define("SESSION_NAME",          "TESTEST");
define("SESSION_LIFETIME",      60 * 60 * 12);
define("SESSION_IDLETIME",      60 * 60);

//URL SETTINGS
define("URL_ASSETS",           "assets/");
define("URL_CSS",              URL_ASSETS."css/");
define("URL_JS",               URL_ASSETS."js/");
define("URL_IMG",              URL_ASSETS."img/");