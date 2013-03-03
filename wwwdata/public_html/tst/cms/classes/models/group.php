<?php

class Group extends Model
{   
    protected $table = "groups";  
    protected $poules = array();
    public function __construct($id = null)
    {
        if (!is_null($id)) {
			parent::load($this->table, 'id', $id);
        } else {          
            $this->id = (integer) $DB->insert(sprintf("INSERT INTO %s (id) VALUES (NULL)", $this->tablename));
        }
    }
}

?>