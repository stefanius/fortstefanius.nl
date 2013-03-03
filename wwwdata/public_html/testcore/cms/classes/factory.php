<?php

/**
 * Load all factory classes
 */
class Factory
{   
    /**
     * Prevents direct creation of object.
     *
     * @param  void
     * @return void
     */
    protected function __construct() {}
    
    /**
     * Returns a factory of type requested.
     *
     * @var string $name,..  name of the factory we want.
     * @return void
     */
    public static function load()
    {
        for ($n = func_num_args(), $i = 0; $i < $n && $arg = func_get_arg($i); $i++) {
            if (class_exists($arg . "Factory")) {
                continue;
            }
            
            $file = PATH_FACTORIES . strtolower($arg) . "_factory.php";
            
            if (!is_readable($file)) {
                throw new Exception("Factory not found: " . $arg);
            }
            
            require $file;
        }
    }
}