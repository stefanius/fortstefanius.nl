<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="nl" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title> </title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="content-script-type" content="text/javascript" />
    <meta http-equiv="content-style-type" content="text/css" />
    <link rel="stylesheet" type="text/css" href="assets/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/template.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/formcheck/theme/classic/formcheck.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="assets/css/squeezebox/squeezebox.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/calendar/calendar.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/autocompleter/autocompleter.css" />
    <script type="text/javascript" src="/assets/js/mootools/core.js"></script>
    <script type="text/javascript" src="/assets/js/mootools/more.js"></script>
    <script type="text/javascript" src="/assets/js/formcheck/lang/nl.js"></script>
    <script type="text/javascript" src="/assets/js/formcheck/formcheck.js"></script>
    <script type="text/javascript" src="/assets/js/squeezebox/squeezebox.js"></script>
    <script type="text/javascript" src="/assets/js/autocompleter/observer.js"></script>
    <script type="text/javascript" src="/assets/js/autocompleter/autocompleter.js"></script>
    <script type="text/javascript" src="/assets/js/autocompleter/autocompleter.request.js"></script>
    <script type="text/javascript" src="/assets/js/calendar.js"></script>
    <script type="text/javascript" src="/assets/js/site.js"></script>
    <!--[if lte IE 6]>
    <script type="text/javascript" src="/assets/js/iepngfix_tilebg.js"></script>
    <style type="text/css">
        img.icon { behavior: url('/admin/assets/htc/iepngfix.htc'); }
    </style>
    <![endif]-->
</head>
<body>
<div id="header" class="clearfix">
    <div style="float: right; text-align: right;">
<?php if (Session::getInstance()->has("admin_id")): ?>
        <ul>
            <li class="first"><a href="/" title="">Dashboard</a></li>
            <li class="last"><a href="/logout" title="">Uitloggen</a></li>
        </ul>
<?php else: ?>
        <ul>
            <li class="first"><a href="http://www.wssn.nl/" title="">Corporate website</a></li>
        </ul>
<?php endif; ?>
    </div>
</div>