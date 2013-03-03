<?php

class PartijModel extends CoreModel{
    var $table = 'partij';
    var $displaykey = 'naam';
    var $naam_displayvalue_samengevoegd;
    var $naam_partij_samengevoegd;
    var $Page;
        
    public function load($field, $value)
    {     
        $return = parent::load($field, $value);
        Loader::loadModel('Page');
        $this->Page = new PageModel();
        $this->Page->load('urlpart',$this->contentpage_urlpart);

        if(!is_null($this->partij_id) && $this->partij_id >0){
            $JoinedModel=new PartijModel($this->table);
            $JoinedModel->load('id', $this->partij_id);
            $this->naam_partij_samengevoegd = $JoinedModel->naam;
            $this->naam_displayvalue_samengevoegd = $JoinedModel->displayvalue;
        }
        
        return $return;
    }
}

?>