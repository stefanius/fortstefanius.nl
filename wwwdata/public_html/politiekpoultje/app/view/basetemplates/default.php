<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo APP_NAME?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">    
    
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <?php
        echo $Template->loadStylesheet('jquery-ui-1.9.1.custom.min.css', URL_CORE_CSS);
        echo $Template->loadStylesheet('bootstrap.css', URL_CORE_CSS);
        echo $Template->loadStylesheet('bootstrap-responsive.css', URL_CORE_CSS);
        
        echo $Template->loadJavascript('packages/ckeditor/ckeditor.js', URL_CORE_ASSETS);
        echo $Template->loadJavascript('jquery-1.8.2.js', URL_CORE_JS);
        echo $Template->loadJavascript('jquery-ui-1.9.1.custom.min.js', URL_CORE_JS);
        echo $Template->loadJavascript('jquery.editinplace.js', URL_CORE_JS);
        echo $Template->loadJavascript('bootstrap.js', URL_CORE_JS);   
        
        $args['basepath']='core';
        $args['element']='feedback.php';
        $args['renderpath']='';  
        $args['result']=$result;  
        echo $Template->render($args);  
    ?>    

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>


  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo URL_BASE ?>"><?php echo APP_NAME ?></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="<?php echo URL_BASE ?>">Home</a></li>
              <!-- <li><a href="#contact">Contact</a></li>
              <li><a href="#about">About</a></li> -->
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Partij <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo URL_BASE ?>partij/add/">Add</a></li>
                  <li><a href="<?php echo URL_BASE ?>partij/index/">Index</a></li>
                  <!--<li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>-->
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Verkiezing <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo URL_BASE ?>verkiezing/add/">Add</a></li>
                  <li><a href="<?php echo URL_BASE ?>verkiezing/index/">Index</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Auteurs <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo URL_BASE ?>auteur/add/">Add</a></li>
                  <li><a href="<?php echo URL_BASE ?>auteur/index/">Index</a></li>
                </ul>
              </li>
            </ul>
            <?php
                $args['basepath']='app';
                $args['element']='login_small.php';
                $args['renderpath']='login/';      
                echo $Template->render($args);
            ?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Welkom</h1>
        <h2>Politiek voor iedereen!</h2>
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="span2">
          <h2>Heading</h2>
          <p>DEFAULT PAGE</a></p>
        </div>
        <div class="span8">
          <p><?php echo $Template->render($View); ?></p>
       </div>
      </div>

      <hr>

      <footer>
        <p>&copy; <a href="http://www.stefanius.nl">Stefanius.nl</a> 2012</p>
      </footer>

    </div> 
     
      
<script type="text/javascript">
window.onload = function()
{
    if(!window.jQuery)
    {
        alert('jQuery not loaded');
    }
    else
    {
        $(document).ready(function(){
            $('#example').tooltip({'placement':'top', 'trigger' : 'hover'});
        });
    }
}
</script>


  </body>

</html>