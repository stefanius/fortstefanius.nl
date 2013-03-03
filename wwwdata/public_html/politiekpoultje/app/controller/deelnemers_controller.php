<?php

class DeelnemersController extends AuthController{
    function add($data=false){
        if(!$data){
             $this->render();
        }else{
            $result = $this->Deelnemers->addnew($data);
            $this->render(array('result' => $result));
        }
    } 
    
    function login($data=false){  
        $user=parent::login($this->Deelnemers, $data);
        $this->Registry->Session
            ->set("User.id",  $user->id)
            ->set("User.nickname",  $user->nickname)
            ->set("timestamp", time());
        $this->render();
    }   
    
    function logout(){
        parent::logout();
        header('location: /');
    }
    
}
?>
