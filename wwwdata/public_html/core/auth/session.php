<?php

class Session
{
    /**
     * @var object  instance of itself once created.
     */
    static private $instance;
    
    /**
     * @var integer  an integer representing the lifetime of a session.
     */
    private $session_lifetime = 0;
    
    /**
     * @var string  a string representing the name we want to use for the session.
     */
    private $session_name = "MySession";
    
    /**
     * @var string  a string representing the path where our session is valid.
     */
    private $session_path = "/";
    
    /**
     * @var string  a string representing the domain we want to use for our session.
     */
    private $session_domain;
    
    /**
     * @var string  a string representing the path where we want to store our sessions.
     */
    private $storage_path;
    
    /**
     * Prevents direct creation of object.
     *
     * @return void
     */
    protected function __construct() {}
    
    /**
     * Prevents to clone the instance.
     *
     * @return void
     */
    private function __clone() {}
    
    /**
     * Gets a single instance of the class the static method is called in.
     *
     * @return object Returns a single instance of the class.
     */
    static public function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Set session lifetime
     *
     * @param integer $session_seconds  an integer representing the lifetime duration in seconds.
     * @return Session  the session object.
     * @see $session_lifetime
     */
    public function setLifetime($seconds = 0)
    {
        $this->session_lifetime = (integer) $seconds;
        return $this;
    }

    /**
     * Set the name for the session cookie
     *
     * @param string $session_name  a string representing the name.
     * @return Session  the session object.
     * @see $session_name
     */
    public function setName($name)
    {
        $this->session_name = (string) $name;
        return $this;
    }
    /**
     * Session path to be used for session cookie
     *
     * @param string $session_path  a string representing the path.
     * @return Session  the session object.
     * @see $session_path
     */
    public function setPath($path)
    {
        $this->session_path = (string) $path;
        return $this;
    }

    /**
     * Set domain to be used for session cookie
     *
     * @param string $session_domain  a string representing the domain.
     * @return Session  the session object.
     * @see $session_domain
     */
    public function setDomain($domain)
    {
        $this->session_domain = (string) $domain;
        return $this;
    }

    /**
     * Set the path for storing session data
     *
     * @param string $storage_path  a string representing the path.
     * @return Session  the session object.
     * @throws Exception  if path is not a directory or writable.
     * @see $storage_path
     */
    public function setDataPath($path)
    {
        if (!is_dir($path) || !is_writeable($path)) {
            throw new Exception("Cannot write session data to: " . $path);
        }
        
        $this->storage_path = $path;
        return $this;
    }

    /**
     * Check if session has variable(s)
     *
     * @param string $key,...  a string or multiple strings representing the name(s).
     * @return boolean  TRUE if they all exist, FALSE if one of them does not.
     */
    public function has()
    {
        for ($n = func_num_args(), $i = 0; $i < $n && $arg = func_get_arg($i); $i++) {
            if (array_key_exists($arg, $_SESSION)) {
                continue;
            } else {
                return FALSE;
            }
        }
        
        return TRUE;
    }

    /**
     * Assign a variable to the active session
     *
     * @param string $key  a string representing the name.
     * @param mixed $value  a value for this variable.
     * @return Session  the session object.
     */
    public function set($key, $value)
    {
        setcookie($this->session_name.$key,$value,time() + $this->session_lifetime); // 86400 = 1 day
        $_SESSION[$key] = $value;
        return $this;
    }

    /**
     * Retrieve a variable from active session
     *
     * @param string $key  a string representing the name.
     * @return mixed  value of the variable.
     * @throws Exception  if active session does not contain variable.
     */
    public function get($key)
    {
        if (array_key_exists($key, $_SESSION)) {
           return $_SESSION[$key];
        }elseif(array_key_exists($this->session_name.$key, $_COOKIE)){
            return $_COOKIE[$this->session_name.$key];
        }else{
            return false;
        }
    }

    /**
     * Erase variable from active session
     *
     * @param string $key  a string representing the name.
     * @return Session  the session object.
     * @throws Exception  if active session does not contain variable.
     */
    public function remove($key)
    {
        if (!array_key_exists($key, $_SESSION)) {
            throw new Exception("Session does not contain: " . $key);
        }
        
        unset($_SESSION[$key]);
        return $this;
    }
    
    /**
     * Start session
     *
     * @return Session  the session object.
     * @throws Exception  if headers have already been output.
     * @throws Exception  if session could not be started.
     */
    public function start()
    {
        if ($this->storage_path != "") {
            ini_set("session.save_path", $this->storage_path);
            session_save_path($this->storage_path);
        }
        
        if ($this->session_lifetime) {
            ini_set("session.gc_maxlifetime", $this->session_lifetime + 300);
        }
        
        if ($this->session_domain) {
            session_set_cookie_params(
                $this->session_lifetime,
                $this->session_path,
                $this->session_domain
            );
        } else {
            session_set_cookie_params(
                $this->session_lifetime,
                $this->session_path
            );
        }
        
        if ($this->session_name) {
            session_name($this->session_name);
        }
         
        if (headers_sent($file, $line)) {
            throw new Exception("Cannot start session, headers already output: " . $file . "#" . $line);
        }
        
        if (!session_start()) {
            throw new Exception("Failed to start session, reason unknown");
        }

        if (isset($_COOKIE[session_name()])) {
            $params = session_get_cookie_params();
            setcookie(session_name(), $_COOKIE[session_name()],
                ($this->session_lifetime ? time() + $this->session_lifetime : 0),
                $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        
        return $this;
    }
    
    /**
     * Wipe all session data and optionally destroy the session cookie
     *
     * @param boolean $destroy
     * @return Session
     */
    public function clear($destroy = TRUE)
    {
        $_SESSION = array();
        
        if ($destroy && isset($_COOKIE[session_name()])) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', mktime(1, 0, 0, 0, 0, 1970),
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
            session_destroy();
        }
        
        return $this;
    }
}