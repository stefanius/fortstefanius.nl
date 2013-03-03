<?php

class SystemFactory
{  
    static public $cache_system = array();
	
    static public function getData($args)
    {
        
        $System = new System($args);
        
        
        return $System;
    }
	
}