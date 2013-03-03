<?php

/**
 * The router
 *
 * The router defines all possible routes the application has to offer,
 * and parses the url requested by the user, trying to determine if it
 * matches any of the existing routes. If so, the appropriate controller,
 * and possiblly also action, will be called.
 */
class Router
{
    /**
     * @var array  the array that holds all defined routes.
     */
    private $routes = array();
    private $split_routes = array();
    
    /**
     * @var string  a string with the base path to all controllers.
     */
    private $path;
    
    /**
     * Constructor
     *
     * @param Registry  the application registry object.
     * @return void
     */
    public function __construct()
    {
    }
    
    /**
     * Set path to controllers
     *
     * @param string  a string with the path to all controllers.
     * @return Router  the router object.
     * @throws Exception  if path is not valid.
     */
    public function setPath($path)
    {
        if (is_dir($path) === FALSE) {
            throw new Exception("Invalid controller path: " . $path);
        }
        
        $this->path = $path;
        return $this;
    }

    /**
     * Clear all known routes
     *
     * @return Router  the router object.
     */
    public function clearRoutes()
    {
        $this->routes = array();
        return $this;
    }
    
    /**
     * Add one or multiple routes
     *
     * @param array $routes  an array containing one or multiple routes.
     * @return Router  the router object.
     */
    public function addRoutes(array $routes)
    {
        $this->routes = array_merge($this->routes, $routes);
            foreach($this->routes as $key => $val){
                $this->split_routes[$val]['url'] = $key;
                $path_components = explode("/", $key);

                foreach ($path_components as $key => $part) {
                        if (empty($part)) {
                                unset($path_components[$key]);
                        }			
                }
                $this->split_routes[]['split'] = $path_components;
            }
        return $this;
    }
    
    /**
     * Routes the current request
     *
     * @param string $url  a string with the url to parse.
     * @return boolean  will return FALSE if no route was matched, otherwise void.
     * @throws Exception  if controller path is not yet set.
     */
    public function route($url = FALSE)
    {
        if (!$this->path) {
            throw new Exception("Controller path not set");
        }
        
        if (!$url) {
            if (!isset($_GET["url"]) || empty($_GET["url"])) {
                $url = "";
            } else {
                $url = $_GET["url"];
            }
        }
                
        // strip trailing "/"
        while (substr($url, -1) == "/") {
            $url = substr($url, 0, strlen($url) - 1);
        }
        
        // strip leading "/"
        while (substr($url, 0, 1) == "/") {
            $url = substr($url, 1);
        }

        $path_components = explode("/", $url);
        
        // remove empty components
        foreach ($path_components as $key => $part) {
            if (empty($part)) {
                unset($path_components[$key]);
            }
        }
        $params=array();
        if(count($path_components)==0){
            $controller = "index"; 
            $action =  "index";        
        }elseif(count($path_components)==1){
            $controller = $path_components[0]; 
            $action =  "index";              
        }elseif(count($path_components)==2){
            $controller = $path_components[0]; 
            $action =  $path_components[1];       
        }else{
            $controller = $path_components[0]; 
            $action =  $path_components[1];    
            $params  = array_slice($path_components, 2);
        }
            
        $this->call($controller, $action, $params);
        
    }
    
    // }}}
    // {{{ call()
    
    /**
     * Call the controller and action requested, pass parameters
     *
     * @param string $file  a string with the file to load.
     * @param string $name  a string with the controller to call.
     * @param string $action  a string with the action to call.
     * @param array $parameters  an array with parameters to pass to the controller.
     * @return void
     * @throws Exception  if file does not exist.
     * @throws Exception  if action does not exist.
     */
    private function call($name, $action, $parameters)
    {
        $file = $this->path . strtolower($name) . "_controller.php";
        
        if (is_readable($file) === FALSE) {
            $action = 'showpage';
            $parameters[]=$name;
            $name = 'page';
            $file = $this->path . strtolower($name) . "_controller.php";

       
           // header("HTTP/1.0 404 Not Found");
           // include_once(PATH_CORE . 'classes/view/404error.php');
           // return;
            //throw new Exception("Controller file is not readable: " . $file);
            //exit;
        }

        require_once $file;

        $class = ucfirst($name)."Controller";

        $object = new $class(strtolower($name), $action,$parameters);

       
        if (is_callable(array($object, $action)) === FALSE) {
            throw new Exception("Does not exist: " . $name . "::" . $action . "()");
        } else {
            if(Request::isPost()){
                $object->$action($_POST);
                //call_user_func_array(array($object, $action), $_POST);
            }elseif(Request::isGet()){
          
               // $object->$action($parameters);
                call_user_func_array(array($object, $action), $parameters);               
            }            
        }
    }
}