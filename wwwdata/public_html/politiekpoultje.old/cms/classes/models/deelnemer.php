<?php

class Deelnemer extends Model
{   
    protected $table = "deelnemers";
    
    public function __construct($args = null)
    {
        if(!is_null($args)){
            parent::load($this->table, $args['collumn'], $args['value']);
        }
    }
    
    public function login($password){
        $Password = new Password();
        return $Password->compare($password, $this->password, ENCRYPTION);
    }    
}

?>