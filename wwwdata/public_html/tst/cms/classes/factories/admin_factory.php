<?php

class AdminFactory
{  
    static public $cache_system = array();
	
    static public function login($username, $password)
    {    
        $Admin = new Admin(array('collumn' => 'naam', 'value' => $username));
        $result = $Admin->login($password);
        return $result;
    }
	
}