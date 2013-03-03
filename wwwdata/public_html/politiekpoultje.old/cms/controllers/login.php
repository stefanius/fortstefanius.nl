<?php

class ControllerLogin extends ControllerExtra
{
    // {{{ __construct()
    
    public function __construct(array $parameters)
    {  
	parent::__construct($parameters);
        Factory::load("Admin", "Deelnemer");
    }
    
    public function admin()
    {		
        $a = AdminFactory::login('stephann', 'secret');
    }
    
    public function index(){
       
    }
    
    public function deelnemer(){
        var_dump($this->Session);
        var_dump(isset(Registry::getInstance()->Deelnemer));
        if(isset(Registry::getInstance()->Deelnemer)){
            echo "al ingelogd!";
        }
        if(array_key_exists('username', $_POST)){
            $username = $_POST["username"];
            $pw = $_POST["pw"];
            $Deelnemer = DeelnemerFactory::login($username,$pw);
            if($Deelnemer){
                Registry::getInstance()->$this->Registry->Deelnemer = $Deelnemer;
                var_dump($this->Registry);
            }else{
                echo "Geen Login!";
            }
        }else{
            echo $this->Template
                ->render("deelnemerlogin.php", TRUE);            
        }

        
    }
  
}