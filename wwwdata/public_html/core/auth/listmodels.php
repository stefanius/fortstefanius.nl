<?php

class ListModels{
    
    private $limit=5;
    private $start=0;
    private $table=null;
    private $modelname=null;
    private $DB=null;
    private $select_from = 'id';
    
    public function __construct($table, $modelname, $DB, $limit=5, $start=0){
        $this->limit=$limit;
        $this->start=$start;
        $this->table= $table;
        $this->modelname= ucwords(strtolower($modelname)).'Model';
        $this->DB=$DB;
        
        if(!class_exists($this->modelname)){
            Loader::loadModel($modelname);
        }
    }
    
    public function setSelectFrom($select_from){
        $this->select_from = $select_from;
    }
    
    public function getList($field, $value, $start = false, $limit = false){
        $list = array();
        $modelname = $this->modelname;

        if($start !== false){
            $this->start=$start;
        }

        if($limit !== false){
            $this->limit=$limit;
        }

        if(is_numeric($value)){
            $guery = "select ".$this->select_from." from ".$this->table." where ".$field." = ".addslashes($value)." order by ".$field." asc limit ".$this->start.', '.$this->limit;
        }else{
            $guery = "select ".$this->select_from." from ".$this->table." where ".$field." like '%".addslashes($value)."%' order by ".$field." asc limit ".$this->start.', '.$this->limit;
        }
       
  
        $rows=$this->DB->select($guery);
        $selectField = $this->select_from;
        
        foreach ($rows as $row) {
            $Model = new $modelname($this->table);

            $Model->load('id', $row->$selectField);
            $list[] = $Model;
        }
        return $list;
    }
    
}

?>