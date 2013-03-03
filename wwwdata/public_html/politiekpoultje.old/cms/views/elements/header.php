<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="nl" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title> </title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="content-script-type" content="text/javascript" />
    <meta http-equiv="content-style-type" content="text/css" />
    <?php
        echo $this->loadStylesheet("reset.css");
        echo $this->loadStylesheet("template.css");
        echo $this->loadStylesheet("formcheck/theme/classic/formcheck.css");//<link rel="stylesheet" type="text/css" href="assets/css/formcheck/theme/classic/formcheck.css" media="screen" />
        echo $this->loadStylesheet("squeezebox/squeezebox.css");
        echo $this->loadStylesheet("autocompleter/autocompleter.css");
        echo $this->loadStylesheet("calendar/calendar.css");       
        
        echo $this->loadJavascript("mootools/core.js");
        echo $this->loadJavascript("mootools/more.js");
        echo $this->loadJavascript("formcheck/lang/nl.js");
        echo $this->loadJavascript("squeezebox/squeezebox.js");
        echo $this->loadJavascript("autocompleter/observer.js");
        echo $this->loadJavascript("autocompleter/autocompleter.js");
        echo $this->loadJavascript("autocompleter/autocompleter.request.js");
        echo $this->loadJavascript("site.js");
    ?>
</head>
<body>
<div id="header" class="clearfix">
    <div style="float: right; text-align: right;">
        <ul>
            <li class="first"><a href="http://www.wssn.nl/" title="">Corporate website</a></li>
        </ul>
    </div>
</div>