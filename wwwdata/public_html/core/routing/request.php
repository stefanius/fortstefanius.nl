<?php
class Request
{ 
    /**
     * Check if request contains variable(s)
     *
     * @param string $key,... a string or multiple strings representing the name(s).
     * @return boolean  TRUE if they all exist, FALSE if one of them does not.
     */
    static public function has()
    {
        for ($n = func_num_args(), $i = 0; $i < $n && $arg = func_get_arg($i); $i++) {
            if (array_key_exists($arg, $_FILES)) {
                continue;
            } elseif (array_key_exists($arg, $_REQUEST)) {
                continue;
            } else {
                return FALSE;
            }
        }
        
        return TRUE;
    }
    
    /**
     * Get the value of a request variable
     *
     * @param string $key  a string representing the name.
     * @return mixed  value of the variable.
     * @throws Exception  if request does not contain the variable.
     */
    static public function get($key)
    {
        if (!self::has($key)) {
            throw new Exception("Request does not contain: " . $key);
        }
        
        if (array_key_exists($key, $_FILES)) {
            return $_FILES[$key];
        }
        
        if (array_key_exists($key, $_REQUEST)) {
            return $_REQUEST[$key];
        }
    }
    
    /**
     * See if request method was POST
     *
     * @return boolean
     */
    static public function isPost()
    {
        if (strcasecmp($_SERVER["REQUEST_METHOD"], "POST") === 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * See if request method was GET
     *
     * @return boolean
     */
    static public function isGet()
    {
        if (strcasecmp($_SERVER["REQUEST_METHOD"], "GET") === 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * See if request method was xmlhttp.
     *
     * @return boolean
     */
    static public function isAjax()
    {
        if (  isset($_SERVER["HTTP_X_REQUEST"])
          && strcmp($_SERVER["HTTP_X_REQUEST"], "JSON") === 0) {
            return TRUE;
        }
        
        if (  isset($_SERVER["HTTP_X_REQUESTED_WITH"])
          && strcmp($_SERVER["HTTP_X_REQUESTED_WITH"], "XMLHttpRequest") === 0) {
            return TRUE;
        }
        
        return FALSE;
    }
}