<?php

class System extends Model
{   
    protected $table = "";
    
    public function __construct($args = null)
    {
        if(!is_null($args)){
            parent::load($args['table'], $args['collumn'], $args['value']);
        }	
    }
}

?>