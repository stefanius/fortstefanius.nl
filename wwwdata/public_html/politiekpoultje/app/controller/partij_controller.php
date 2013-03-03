<?php

class PartijController extends AuthController{
    
    function index(){
        $Partijen = $this->Partij->getList();
        $this->render(array('Partijen'=> $Partijen));       
    }
    
    function view($id=false){
        if($id !== false){
            $this->Partij->load('id', $id);
            $this->render(array('Partij' => $this->Partij));           
        }
    }
    
    function add($data=false){
        Loader::loadModel('Page');
        $Page = new PageModel();
        $Pages = $Page->getList();
        if($this->checkLogin()){
            if(!$data){
                $this->render(array('Pages'=>$Pages));
            }else{
                $data['user_id'] = $this->Registry->Session->get("User.id");
                $result = $this->Partij->addnew($data);
                $this->render(array('result' => $result));
            }
        }
    } 
   
    function edit($data=false){        
        if($this->checkLogin()){
            if(is_numeric($data)){
               $this->Partij->load('id', $data);
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
    }  
}
?>
