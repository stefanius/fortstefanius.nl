<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */

class ControllerSystem extends ControllerExtra
{
    // {{{ __construct()
    
    public function __construct(array $parameters)
    {  
	parent::__construct($parameters);
        Factory::load("System");
    }
    
    public function index()
    {
	$args['table'] = $this->parameters["table"];
	$args['collumn'] =$this->parameters["collumn"];
	$args['value'] = $this->parameters["value"];
	$System = SystemFactory::getData($args);       
        echo $this->Template
            ->set("System", $System)
            ->render("system/index.php");		
		
    }
  
}