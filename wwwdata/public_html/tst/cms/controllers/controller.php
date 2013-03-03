<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */

class ControllerExtra extends ControllerBase
{
    // {{{ __construct()
    
    public function __construct(array $parameters)
    {
        parent::__construct($parameters);
    }
    
    public function checkLogin($role = "", $lifetime = 300, $redirect = false)
    {
        $Session = Session::getInstance();
        
        if (!$Session->has($role))
        {
            if ($redirect === false)
            {
                return false;
            }
            
            header("Location: " . $redirect, true, 302);
            exit;
        }
        
        $expires = time() - $lifetime;
        
        if ($Session->get("timestamp") < $expires)
        {
            $Session->clear(true);
            
            if ($redirect === false)
            {
                return false;
            }
            
            header("Location: " . $redirect, true, 302);
            exit;
        }               
        $Session->set("timestamp", time());        
        return true;
    }    
  
}