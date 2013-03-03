<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of encryption
 *
 * @author Stefanius
 */
class Password {
    public function getRandomSalt(){
        $date = date('l jS \of F Y h:i:s A');
        $randomstring = $this->genRandomString(20);
        $salt = md5($date.$randomstring);
        return $salt;
    }
    
    public function genRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string ='';    
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters-1))];
        }
        return $string;
    }
    
    public function compare($password, $hash, $method = "md5"){
        $passed = false;
        
        if($method == "md5"){
            if(md5($password) == $hash){
                $passed = true;
            }          
        }elseif("joomla_classic"){
            $arr = explode(":", $hash);
            $salt = $arr[1];
            $encrypted=$arr[0];
            
            if(md5($password.$salt) == $encrypted){
                $passed = true;
            }              
        }
        
        return $passed;
    }
    
    public function encrypt($password, $method = "md5"){
        $hashed ="";
        
        if($method == "md5"){
            $hashed = md5($password);
        }elseif("joomla_classic"){
            $salt = $this->getRandomSalt();
            $hashed = md5($password.$salt).":".$salt;
        }        
        
        return $hashed;
    }

}

?>
