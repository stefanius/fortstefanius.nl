<?php

class BlogController extends AuthController{
    function index(){
        $Pages = $this->Page->getList();
        $this->render(array('Blogs'=> $Blogs));       
    }
    
    function view($id=false){
        if($id !== false){
            $this->Page->load('id', $id);
            $this->render(array('Blog' => $this->Blog));           
        }
    }
    
    function add($data=false){
        if($this->checkLogin()){
            if(!$data){
                $this->render();
            }else{
                $result = $this->Blog->addnew($data);
                $this->render(array('result' => $result));
            }
        }
    } 
   
    function edit($data=false){        
        if($this->checkLogin()){
            if(is_numeric($data)){
               $this->Blog->load('id', $data);
               $this->render(array('Blog' => $this->Blog));
            }elseif(!$data){
                //$this->render();
            }else{              
                $result = $this->Blog->update($data);
                if(!$result){
                    $message = "Bijwerken is mislukt";
                    $msgType = 'error';
                }else{
                    $message = "Blog is succesvol bijgewerkt";
                    $msgType = 'succes';
                }
                $this->render(array('message' => $message, 'msgType' => $msgType, 'Blog' => $this->Blog));
            }
        }
    }
}
?>
