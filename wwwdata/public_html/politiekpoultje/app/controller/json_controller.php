<?php

class JsonController extends CoreController
{
    public function __construct() {
        
    }
    
    public function find($modelname, $field, $value)
    {           
        $modelname=  ucwords(strtolower($modelname));
        $this->loadModel($modelname);
        $model= new $this->$modelname();
        
        $jsonlist = array();
        $i=0;
        $list=$model->getList(0, 10, $field, $value);
        
        foreach($list as $l){
           $jsonlist[$i]['id']=$l->id;
           $jsonlist[$i]['value']=$l->$field;
           $i++;
       }

        echo json_encode($jsonlist);
        exit;
    }
    
    public function validate(){
        
    }
    
    public function validate_autocomplete($modelname, $json_id, $json_value){
        $modelname=  ucwords(strtolower($modelname));
        $this->loadModel($modelname);
        $model=$this->$modelname;
        $checked=false;
        
        if(is_object($model)){
            if($json_id > -1 && is_numeric($json_id)){
                $model->load('id', $json_id);
               
                if($model->displayvalue==$json_value){
                    $checked=true;
                }else{
                    $checked=false;
                }
            }else{
                $checked=false;
            }            
        }else{
            $checked=false;
        }    
       // echo json_encode(array('checked'=>'arie'));
       echo $checked;
        exit;
    }
}