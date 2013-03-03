<?php

class VerkiezingController extends AuthController{
    
    function index(){
        $Verkiezingen = $this->Verkiezing->getList();    
        $this->render(array('Verkiezingen' =>$Verkiezingen));
    }
    
    function add($data=false){
 
        if($this->checkLogin()){
            if(!$data){
                $Verkiezingtypes = $this->listVerkiezingTypes();
                $Partijen = $this->listPartijen('naam', '');
                $this->render(array('Verkiezingtypes' =>$Verkiezingtypes, 'Partijen'=> $Partijen));
            }else{
                $result = $this->Verkiezing->addnew($data);
                if(!$result){
                    $message = "Opslaan is mislukt";
                    $msgType = 'error';
                }else{
                    $this->Verkiezing->addnew_many_to_many($data, 'partijlist', 'verkiezing');
                    $message = "Verkiezing is succesvol opgeslagen";
                    $msgType = 'succes';
                }
                $this->render(array('message' => $message, 'msgType' => $msgType, 'Verkiezing' => $this->Verkiezing));
            }
        }
    }
    
    function view($id=false){
        if($id !== false){
            echo $id;
            $this->Verkiezing->load('id', $id);
            $this->render(array('Verkiezing' => $this->Verkiezing));
        }
    }
        
    function edit($data=false){        
        if($this->checkLogin()){
            if(is_numeric($data)){
                $this->Verkiezing->load('id', $data);
                $Verkiezingtype = new VerkiezingtypeModel();
                $Partij = new PartijModel();
                $Verkiezingtypes = $Verkiezingtype->getList();
                $P = array();
                $Partijen = $Partij->getList(0, 100);
                
                foreach($this->Verkiezing->Partijen as $PP){
                    $P = array_merge($P, $Partij->getList(0, 1, 'id', $PP->id));
                }
                
                $this->Verkiezing->Partijen = $P;

                $this->render(array('Verkiezingtypes' =>$Verkiezingtypes, 'Partijen'=> $Partijen, 'Verkiezing' => $this->Verkiezing));
            }elseif(!$data){
                //$this->render();
            }else{           
                $this->Verkiezing->load('id', $data['id']);
                $result = $this->Verkiezing->update($data);
                $Partij = new PartijModel();
                $Verkiezingtype = new VerkiezingtypeModel();
                if(!$result){
                    $message = "Bijwerken is mislukt";
                    $msgType = 'error';
                }else{
                    $message = "Verkiezing is succesvol bijgewerkt";
                    $msgType = 'succes';
                }
                $Verkiezingtypes = $Verkiezingtype->getList();
                $P = array();
                $Partijen = $Partij->getList(0, 100);
                
                foreach($this->Verkiezing->Partijen as $PP){
                    $P = array_merge($P, $Partij->getList(0, 1, 'id', $PP->id));
                }
                
                $this->Verkiezing->Partijen = $P;
                $this->render(array('message' => $message, 'msgType' => $msgType, 'Verkiezing' => $this->Verkiezing, 'Verkiezingtypes' =>$Verkiezingtypes, 'Partijen'=> $Partijen));
            }
        }
    }
}
?>
