<?php
define("DO_DEBUGGING", TRUE);
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("APP_NAME", "Politiekpoultje.nl");
define("DB_PSWD", "");
define("BASE_URL", "/politiekpoultje/");
define("PATH_CSS", BASE_URL."assets/css/");
define("PATH_JS", BASE_URL."assets/ja/");
/**
 * @var string  a string with the db server database to select.
 */
define("DB_BASE", "politiekpoultje");

// }}}
// {{{ Error reporting

/**
 * @var boolean  a boolean defining if we want to convert php errors into exceptions.
 */
define("ERROR_THROW", TRUE);

/**
 * @var integer  holds error reporting level, bitwise.
 */
define("ERROR_LEVEL", E_ERROR);

define("VIEW_PATH", PATH_APP . "views/");
define("TEMPLATE_PATH_CACHE", PATH_TMP . "cache/view/");
define("SESSION_NAME", APP_NAME);
define("SESSION_LIFETIME", 60 * 60 * 12);
define("SESSION_IDLETIME", 60 * 60);
define("ROUTER_PATH", PATH_APP . "controllers/");