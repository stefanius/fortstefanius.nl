<?php

class PageController extends AuthController{
    function index(){
        $Pages = $this->Page->getList();
        $this->render(array('Pages'=> $Pages));       
    }
    
    function view($id=false){
        if($id !== false){
            $this->Page->load('id', $id);
            $this->render(array('Page' => $this->Page));           
        }
    }
    
    function add($data=false){
        if($this->checkLogin()){
            if(!$data){
                $this->render();
            }else{
                $result = $this->Page->addnew($data);
                $this->render(array('result' => $result));
            }
        }
    } 
   
    function edit($data=false){        
        if($this->checkLogin()){
            if(is_numeric($data)){
               $this->Page->load('id', $data);
               $this->render(array('Page' => $this->Page));
            }elseif(!$data){
                //$this->render();
            }else{              
                $result = $this->Page->update($data);
                if(!$result){
                    $message = "Bijwerken is mislukt";
                    $msgType = 'error';
                }else{
                    $message = "Auteur is succesvol bijgewerkt";
                    $msgType = 'succes';
                }
                $this->render(array('message' => $message, 'msgType' => $msgType, 'Page' => $this->Page));
            }
        }
    }
    
    function showpage($urlpart){
       $this->Page->load('urlpart', $urlpart);
       $this->render(array('Page' => $this->Page));
    }
}
?>
