<?php
/* Element wich contains all Bootstrap JS files. */
$Registry = Registry::getInstance();
$Template = $Registry->Template;

$BOOTSTRAP_JS=URL_CORE_JS;

echo $Template->loadJavascript('jquery.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap.js', $BOOTSTRAP_JS);
//echo $Template->loadJavascript('bootstrap.min.js', $BOOTSTRAP_JS);

/*
$BOOTSTRAP_JS=URL_CORE_PACKAGES.'templates/bootstrap/js/';
echo $Template->loadJavascript('bootstrap-affix.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-alert.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-button.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-carousel.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-collapse.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-dropdown.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-modal.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-popover.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-scrollspy.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-tab.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-tooltip.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-transition.js', $BOOTSTRAP_JS);
echo $Template->loadJavascript('bootstrap-typeahead.js', $BOOTSTRAP_JS);

*/
?>
