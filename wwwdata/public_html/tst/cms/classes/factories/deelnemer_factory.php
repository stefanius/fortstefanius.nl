<?php

class DeelnemerFactory
{  
    static public $cache_system = array();
	
    static public function login($username, $password)
    {    
        $Deelnemer = new Deelnemer(array('collumn' => 'mail', 'value' => $username));
        $result = $Deelnemer->login($password);
        if($result){
            return $Deelnemer;
        }else{
            return FALSE;
        }
        
    }
	
}