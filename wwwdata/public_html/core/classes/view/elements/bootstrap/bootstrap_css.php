<?php
/* Element wich contains all Bootstrap JS files. */
$Registry = Registry::getInstance();
$Template = $Registry->Template;

$BOOTSTRAP_CSS=URL_CORE_CSS;

echo $Template->loadStylesheet('bootstrap.css', $BOOTSTRAP_CSS);
echo $Template->loadStylesheet('bootstrap-responsive.css', $BOOTSTRAP_CSS);

?>
