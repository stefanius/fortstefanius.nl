<?php

class PageModel extends CoreModel{
    var $table = 'contentpages';
    var $displaykey = 'title';
    var $Sections = array();
    
    public function load($field, $value)
    {     
        $return = parent::load($field, $value);
        Loader::loadModel('Section');
        
        $result = $this->DB->get_where($this->table, array($field => $value));
        $this->Section = new PageModel();
        $this->Section->load('urlpart',$this->contentpage_urlpart);

        if(!is_null($this->partij_id) && $this->partij_id >0){
            $JoinedModel=new PartijModel($this->table);
            $JoinedModel->load('id', $this->partij_id);
            $this->naam_partij_samengevoegd = $JoinedModel->naam;
            $this->naam_displayvalue_samengevoegd = $JoinedModel->displayvalue;
        }
        
        return $return;
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
}

?>