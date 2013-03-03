<?php

class PouleFactory
{  
    static public $cache_system = array();
	
    static public function getData($id)
    {      
        $Poule = new Poule(array('collumn'=>'id', 'value'=>$id));      
        return $Poule;
    }
	
}