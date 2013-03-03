<?php

class AuteurController extends AuthController{
    function index(){
        $Auteurs = $this->Auteur->getList();
        $this->render(array('Auteurs'=> $Auteurs));       
    }
    
    function view($id=false){
        if($id !== false){
            $this->Auteur->load('id', $id);
            $this->render(array('Auteur' => $this->Auteur));           
        }
    }
    
    function add($data=false){
        if($this->checkLogin()){
            if(!$data){
                $this->render();
            }else{
                $result = $this->Auteur->addnew($data);
                $this->render(array('result' => $result));
            }
        }
    } 
   
    function edit($data=false){        
        if($this->checkLogin()){
            if(is_numeric($data)){
               $this->Auteur->load('id', $data);
               $this->render(array('Auteur' => $this->Auteur));
            }elseif(!$data){
                //$this->render();
            }else{              
                $this->Auteur->load('id', $data['id']);
                $result = $this->Auteur->update($data);
                if(!$result){
                    $message = "Bijwerken is mislukt";
                    $msgType = 'error';
                }else{
                    $message = "Auteur is succesvol bijgewerkt";
                    $msgType = 'succes';
                }
                $this->render(array('message' => $message, 'msgType' => $msgType, 'Auteur' => $this->Auteur));
            }
        }
    }
}
?>
