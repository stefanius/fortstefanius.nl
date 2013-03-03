<?php

class UitslagController extends AuthController{
    
    function add($data=false){
        if($this->checkLogin()){
            if(is_numeric($data)){
               $this->Uitslag->load('id', $data);
               $this->render(array('Partij' => $this->Partij));
            }elseif(!$data){
                //$this->render();
            }else{
                
                $this->Partij->load('id', $data['id']);
                $result = $this->Partij->update($data);
                if(!$result){
                    $message = "Bijwerken is mislukt";
                    $msgType = 'error';
                }else{
                    $message = "Partij is succesvol bijgewerkt";
                    $msgType = 'succes';
                }
                $this->render(array('message' => $message, 'msgType' => $msgType, 'Partij' => $this->Partij));
            }
        }
     
        if($this->checkLogin()){
            if(!$data){
                $data['user_id'] = $this->Registry->Session->get("User.id");
                $Verkiezingtypes = $this->listVerkiezingen();
                $Partijen = $this->listPartijen();
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
}
?>
