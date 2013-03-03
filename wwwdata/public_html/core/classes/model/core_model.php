<?php

class CoreModel{
    protected $table;
    protected $useTable=true;
    protected $data = array();
    protected $relationships = array();
    protected $DB;
    protected $properties_cached = array();
    protected $displaykey;
    protected $altertable=true; //Used to alter the table autmaticly by adding a created and modified field to it.
    protected $pk = array('id'); //primary key
    public $displayvalue;
    
    public function __construct($tablename=null)
    {
        $this->init($tablename);
    }
    
    protected function init()
    {
        $this->DB = Registry::getInstance()->DB;

        if($this->useTable){
            $rows = $this->DB->list_fields($this->table);
            foreach ($rows as $row) {
                $this->data[$row] =NULL;    
            }
        }
    }
    
    public function addnew($data)
    {
        if(array_key_exists('created', $this->data)){
            $data['created']='NOW()';
        }

        foreach($data as $key=>$value)
        {
            if(array_key_exists($key, $this->data) && !is_array($value))
            {
                $this->$key = $value;
                $this->DB->set($key,$value);
            }     
        }
        $this->DB->insert($this->table);
        $this->id = $this->DB->insert_id();
        return $this->id;
    }
  
    public function getFieldnames(){
        return array_keys($this->data);
    }
    
    public function update($data = array()){
  
        foreach ($this->data as $fieldname=>$value)
        { 
            if(array_key_exists($fieldname, $data)){
                $this->$fieldname = $data[$fieldname];
            }
        }    
        
        return $this->save();
    }
    
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->data)) {
                if($value != ''){
                    $this->data[$name] = $value;  
                }else{
                    $this->data[$name] = null;
                }                        
            }            
        
    }    

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name]; 
        }
    }    
    
    public function save()
    {
        if(array_key_exists('created', $this->data)){
            if($this->data['created']['Value']=='0000-00-00 00:00:00'){
                $this->data['created']['Value']='NOW()';
            }elseif ($this->data['created']['Value']=='') {
                $this->data['created']['Value']='NOW()';
            }            
        }
        
        foreach($this->pk as $key){
            $this->DB->where($key, $this->data[$key]);
        }

        $this->DB->update($this->table, $this->data);
        return $this;
    }
    
    public function load($field, $value)
    {
        $result = $this->DB->get_where($this->table, array($field => $value));
        
        if($result !== false){
            $DBobject = $result->row(0);

            foreach($this->data as $key=>$value){
                $this->data[$key] = $DBobject->$key;
            }    
            
            if(isset($this->displaykey)){
                $this->displayvalue = $this->data[$this->displaykey];
            }
            $return = $this;
            
        }else{
            $return = false;
        }
        
        return $return;
    }
	
    public function delete()
    {
        throw new Exception("Not Implemented");
    }
	
    public function __unset($key)
    {
        throw new Exception("Not Implemented");
    }
    
    public function getTable(){
        return $this->table;
    }
    
    public function getList($offset = 0, $limit = 10, $field=false, $value=false){
        if($field !== false && $value !== false){
            if(is_numeric($value)){
                $result = $this->DB->get_where($this->table, array($field => $value), $limit, $offset);
            }else{
                $this->DB->select('*')->from($this->table)->like($field, $value)->limit($limit, $offset);
                $result = $this->DB->get();
            }
            
        }else{
            $result = $this->DB->get($this->table, $limit, $offset);
        }       
        return $result->result();
    }
}

?>
