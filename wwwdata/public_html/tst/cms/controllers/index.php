<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */

class ControllerIndex extends ControllerExtra
{
    // {{{ __construct()
    
    public function __construct(array $parameters)
    {  
	parent::__construct($parameters);
        Factory::load("System");
    }
    
    public function index()
    {		

    }
  
}