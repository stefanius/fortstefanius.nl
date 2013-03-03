<?php

class Poule extends Model
{   
    protected $table = "poule";
    var $Author; //Deelnemer welke de Poule heeft aangemaakt
    
    public function __construct($args = null)
    {
        if(!is_null($args)){
            parent::load($this->table, $args['collumn'], $args['value']);
        }
        $this->Author = new Deelnemer(array('collumn' => 'id', 'value' => $this->deelnemer_id));
    }
}

?>