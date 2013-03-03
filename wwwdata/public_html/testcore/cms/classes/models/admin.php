<?php

class Admin extends Model
{   
    protected $table = "admin";
    
    public function __construct($args, $new=false)
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