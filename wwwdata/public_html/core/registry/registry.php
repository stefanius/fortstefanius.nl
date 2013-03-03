<?php

/**
 * The global registry
 *
 * The Registry object provides a mechanism for storing data globally in a
 * well managed fashion, helping to prevent acute meltdown of the brain.
 * It implements the ArrayAccess interface to facilitate usage as an array,
 * but basic overloading is also available. Example:
 *
 * <code>
 * $registry = Registry::getInstance();
 * $registry["a"] = $objectA;
 * $registry->b   = $objectB;
 * </code>
 */
class Registry implements ArrayAccess
{
   
    /**
     * @var object $instance instance of itself once created.
     * @var array $storrage the array that holds all assigned variables.
     */
    static private $instance;
    private $storage = array();
    
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
     * @param  void
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
     * Assign a variable to the registry
     *
     * @param string $key  a string representing the name.
     * @param mixed $value  a mixed value for the variable.
     * @return Registry  the registry object.
     * @throws Exception  if the registry already contains a variable with given name.
     * @throws Exception  if no name has been given.
     */
    public function __set($key, $value)
    {
        if (empty($key)) {
            throw new Exception("Cannot overwrite internal storage.");
        }
        
        if ($this->__isset($key)) {
            throw new Exception("Registry already contains: " . $key);
        }
        
        $this->storage[$key] = $value;
        return $this;
    }
    
    /**
     * Assign a variable to the registry
     *
     * @param string $key  a string representing the name.
     * @param mixed $value  a mixed value for the variable.
     * @return Registry  the registry object.
     * @see __set()
     * @throws Exception  if the registry already contains a variable with given name.
     * @throws Exception  if no name has been given.
     */
    public function offsetSet($key, $value)
    {
        return $this->__set($key, $value);
    }
    
    /**
     * Get variable from registry
     *
     * @param string $key  a string representing the name.
     * @return mixed  value of variable.
     * @throws Exception  if registry does not have variable.
     */
    public function __get($key)
    {
        if (!$this->__isset($key)) {
            throw new Exception("Registry does not contain: " . $key);
        }
        
        return $this->storage[$key];
    }
    
    /**
     * Get variable from registry
     *
     * @param string $key  a string representing the name.
     * @return mixed  value of variable.
     * @see __get()
     * @throws Exception  if registry does not have variable.
     */
    public function offsetGet($key)
    {
        return $this->__get($key);
    }
    
    /**
     * Check if registry contains variable
     *
     * @param string $key  a string representing the name of the variable.
     * @return boolean
     */
    public function __isset($key)
    {
        return array_key_exists($key, $this->storage);
    }
    
    /**
     * Check if registry contains variable
     *
     * @param string $key  a string representing the name of the variable.
     * @return boolean
     * @see __isset()
     */
    public function offsetExists($key)
    {
        return $this->__isset($key);
    }
   
    /**
     * Unset a variable
     *
     * @param string $key  a string representing the name.
     * @return Registry  the registry object.
     * @throws Exception  if the registry does not contain variable.
     */
    public function __unset($key)
    {
        if (!$this->__isset($key)) {
            throw new Exception("Registry does not contain: " . $key);
        }
        
        unset($this->storage[$key]);
        return $this;
    }
      
    /**
     * Unset a variable
     *
     * @param string $key  a string representing the name.
     * @return Registry  the registry object.
     * @see __unset()
     * @throws Exception  if the registry does not contain variable.
     */
    public function offsetUnset($key)
    {
        return $this->__unset($key);
    }
}