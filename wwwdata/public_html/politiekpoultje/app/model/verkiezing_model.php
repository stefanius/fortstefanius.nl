<?php

class VerkiezingModel extends CoreModel{
    var $table = 'verkiezing';
    var $PartijList = array(); //Used for adding parties
    var $Partijen = array(); //used for other purposes.
    var $Verkiezingtype;
    

    public function load($field, $value)
    {       

        $return = parent::load($field, $value);

        if($return !== false){
           
            Loader::loadModel('Verkiezingtype');
            Loader::loadModel('Partij');
            Loader::loadModel('Partijverkiezing');
            $Verkiezingtype = new VerkiezingtypeModel();
            $Partijverkiezing = new PartijverkiezingModel();
            
            $this->Verkiezingtype = $Verkiezingtype->load('id', (int)$this->verkiezingtype_id);
                  
            $PartijverkiezingLijst = $Partijverkiezing->getList(0, 50, 'verkiezing_id', $this->id);
            
            foreach ($PartijverkiezingLijst as $Partij_id){
                $Partij = new PartijModel();
                $Partij->load('id', $Partij_id->partij_id );
                $this->Partijen[] = $Partij;
            }
       }
        
        return $this;
    }    
}

?>