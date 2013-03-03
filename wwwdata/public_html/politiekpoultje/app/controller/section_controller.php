<?php

class SectionController extends AuthController{
    
    function index(){
        $Partijen = $this->Partij->getList();
        $this->render(array('Sections'=> $Sections));       
    }
    
    function view($id=false){
        if($id !== false){
            $this->Section->load('id', $id);
            $this->render(array('Section' => $this->Section));           
        }
    }
    
    function add($data=false){
        if($this->checkLogin()){
            if(!$data){
                $this->render();
            }else{
                $data['user_id'] = $this->Registry->Session->get("User.id");
                $result = $this->Section->addnew($data);
                $this->render(array('result' => $result));
            }
        }
    } 
   
    function edit($data=false){        
        if($this->checkLogin()){
            if(is_numeric($data)){
               $this->Section->load('id', $data);
               $this->render(array('Section' => $this->Section));
            }elseif(!$data){
                //$this->render();
            }else{              
                $this->Section->load('id', $data['id']);
                $result = $this->Section->update($data);
                if(!$result){
                    $message = "Bijwerken is mislukt";
                    $msgType = 'error';
                }else{
                    $message = "Section is succesvol bijgewerkt";
                    $msgType = 'succes';
                }
                $this->render(array('message' => $message, 'msgType' => $msgType, 'Partij' => $this->Section));
            }
        }
    }  
}
?>
