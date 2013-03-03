<?php

class Deelnemer extends Model
{   
    protected $table = "partij";
    
    public function __construct($args = null)
    {
        if(!is_null($args)){
            parent::load($this->table, $args['collumn'], $args['value']);
        }
    }
}

?>