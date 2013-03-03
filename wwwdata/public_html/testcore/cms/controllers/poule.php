<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */

class ControllerPoule extends ControllerExtra
{
    // {{{ __construct()
    
    public function __construct(array $parameters)
    {  
	parent::__construct($parameters);
        Factory::load("Poule");
    }
    
    public function show()
    {
	$id = $this->parameters["id"];
	$Poule = PouleFactory::getData($id);   
        echo $this->Template
            ->set("Poule", $Poule)
            ->render("poule/show.php");				
    }
  
}