<?php

class AuthModel extends CoreModel{

    private $Password;
    protected $loginname;
    
    public function __construct() {
        parent::init();
        $this->Password = new Password();
    }
    
    public function addnew($data, $validate=false)
    {
        if(array_key_exists('password', $data)){
            $data['password'] = $this->Password->encrypt( $data['password'], DEFAULT_PW_HASH);
        }
        return parent::addnew($data, $validate); 
    }
}

?>
