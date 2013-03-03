<?php

class AuthController extends CoreController{
    private $Password;
    
    public function __construct($renderpath, $actionview) {
        parent::init($renderpath, $actionview);
        $this->Password = new Password();
    }
    
    function login(AuthModel $AuthModel, $data=false)
    {
        $result=false;
        if($data !== false){
            $user = $AuthModel->load($AuthModel->loginname, $data[$AuthModel->loginname]);
        
            if($user !== false)
            {
                $result = $this->Password->compare($data['password'], $AuthModel->password, DEFAULT_PW_HASH);
            }
        }

        if($result){
            return $user;
        }else{
            return $result;
        }
    }  
    
    function logout()
    {
        $this->Registry->Session->clear();
    }  
   
    public function checkLogin($lifetime = 300, $checkKey='User.id')
    {
        $logincheck=false;    
        $breakOtherChecks=false;
        $expires = time() - $lifetime;
        
        $sessionkey = $this->Registry->Session->get($checkKey);
        
        if(!$sessionkey){
            $logincheck=false;
            $breakOtherChecks=true;
        }

        if (($this->Registry->Session->get("timestamp") < $expires) || ($breakOtherChecks))
        {
            $logincheck=false;
        }else{
            $logincheck=true;
        }   

        if ($logincheck)
        {
            $this->Registry->Session->set("timestamp", time());
        }else{
            $this->Registry->Session->clear(true);
            
            header("Location: ". URL_LOGIN_ACTION, true, 403);
            exit;
        }

        return $logincheck;
    }
}
?>
