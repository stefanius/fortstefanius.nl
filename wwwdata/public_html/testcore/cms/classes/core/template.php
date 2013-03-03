<?php

/**
 * Simple templating class
 *
 * Very basic template rendering class. Assign variables using {@see Template::set()},
 * then render a template by calling {@see Template::render()}. Any assigned variables
 * are extracted and prefixed with a '_' before the rendering action. This allows for
 * easy access to them inside the template file. Caching options are also provided
 * by {@see Template::render()}. Though functionality is basic and only useful for
 * static files, because variables are not extracted nor parsed for cached files.
 */
class Template
{
    // {{{ properties
    
    /**
     * @var array  the array that holds all template assigned variables.
     */
    private $storage = array();
    
    /**
     * @var string  a string representing the root path for templates.
     * @deprecated replaced by $templatePath and $elementPath
     */
    private $path;
    
    /**
     * @var string  a string representing the root path for the views.
     */
    private $templatePath;
  
    /**
     * @var string  a string representing the root path for the reuseable elements.
     */
    private $elementPath;
    
    /**
     * @var string  a string representing the root path for cache.
     */
    private $cache_path;
    
    /**
     * @var integer  an integer that holds a bitwise value representing
     *               the output stripping level.
     */
    private $strip_output_level;
    
    // }}}
    // {{{ __construct()
    
    /**
     * Contructor
     *
     * @param Registry $registry  the application registry.
     * @return void
     */
    public function __construct()
    {
    }
    
    // }}}
    // {{{ has()
    
    /**
     * Check if template instance has variable assigned
     *
     * @param string $key  a string representing the name of the variable.
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->storage);
    }
    
    // }}}
    // {{{ set()
    
    /**
     * Assign a variable to the template object
     *
     * Variables should be passed in the form of key and value,
     * and will be extracted upon rendering of the template. They
     * can then be referenced by _key inside template files.
     *
     * @param string $key  a string representing the name.
     * @param mixed $value  a mixed value belonging to the variable.
     * @return Template  the template object.
     */
    public function set($key, $value)
    {
        $this->storage[$key] = $value;
        return $this;
    }
    
    // }}}
    // {{{ get()
    
    /**
     * Retrieve a variable assigned to the template object
     *
     * @param string $key  a string representing the name.
     * @return mixed  value of the variable.
     * @throws Exception  if variable is not assigned to template object.
     */
    public function get($key)
    {
        if (!array_key_exists($key, $this->storage)) {
            throw new Exception("Template does not contain: " . $key);
        }
        
        return $this->storage[$key];
    }
    
    // }}}
    // {{{ remove()
    
    /**
     * Remove a variable from the template object
     *
     * @param string $key  a string representing the name.
     * @return Template  the template object.
     * @throws Exception  if variable is not assigned to template object.
     */
    public function remove($key)
    {
        if (!array_key_exists($key, $this->storage)) {
            throw new Exception("Template does not contain: " . $key);
        }
        
        unset($this->storage[$key]);
        return $this;
    }
    
    // }}}
    // {{{ setOutputStripping()
    
    /**
     * Set the output stripping level
     *
     *   1st bit set, strip all empty lines
     *   2nd bit set, strip all tab indentation
     *   3th bit set, strip all linebreaks
     *   4rd bit set, strip all excess whitespace
     *
     * @param integer  an integer holding the bitewise value of the desired level.
     * @return Template  the template object.
     * @see $strip_output_level
     */
    public function setOutputStripping($value)
    {
        $this->strip_output_level = $value;
        return $this;
    }
    
    // }}}
    // {{{ setPath()
    
    /**
     * Set path to templates
     *
     * @param string $path  a string representing the path.
     * @return Template  the template object.
     * @throws Exception  if path given is not a valid directory.
     */
    public function setPath($path)
    {
        if (!is_dir($path)) {
            throw new Exception("Invalid template path: " . $path);
        }
        
        if (!is_dir($path.'elements')) {
            throw new Exception("Elements folder not found in view-path. Make sure it is there. " . $path);
        }

        if (!is_dir($path.'templates')) {
            throw new Exception("Templates folder not found in view-path. Make sure it is there. " . $path);
        }
        
        $this->templatePath = $path.'templates/';
        $this->elementPath = $path.'elements/';
        return $this;
    }
    
    // }}}
    // {{{ setCachePath()
    
    /**
     * Set path to cache
     *
     * @param string $path  a string representing the path.
     * @return Template  the template object.
     * @throws Exception  if path does not exist and could not be created.
     * @throws Exception  if path exists but could not be made writeable.
     */
    public function setCachePath($path)
    {
        if (!is_dir(dirname($path))) {
            if (!mkdir(dirname($path), 0755, TRUE)) {
                throw new Exception("Could not create cache directory: " . $path);
            }
        }
        
        if (!is_writable(dirname($path))) {
            $filemode = 0755;
            $iterator = new RecursiveIteratorIterator(
                            new RecursiveDirectoryIterator($path),
                            RecursiveIteratorIterator::SELF_FIRST
                        );
                        
            foreach ($iterator as $item) {
                if (!chmod($item, $filemode)) {
                    throw new Exception("Could not make writeable: " . $item);
                }
            }
        }
        
        $this->cache_path = $path;
        return $this;
    }
    
    // }}}
    // {{{ render()
    
    /**
     * Render template and store in internal buffer
     *
     * @param string $template  a string representing the filename of the template.
     *                          This should be relative from the template base path.
     * @param boolean $element  a boolean to identify a view as a template or a reuseable element. Default is FALSE.
     * @param integer $cache  how long the template should be cached (in seconds).
     *                        Alternative values are FALSE for never and TRUE for
     *                        forever. If a cached version exists and is fresh enough,
     *                        it is used instead.
     * @return Template  the template object.
     * @throws Exception  if template path is not known.
     * @throws Exception  if requested template cannot be found.
     * @throws Exception  if cache path is not known and $cache is not FALSE.
     * @throws Exception  if old cache file cannot be unlinked.
     * @throws Exception  if template buffer could not be created.
     */
    public function render($template, $element = FALSE, $cache = FALSE)
    {
        if($element){
            $use_path = $this->elementPath;
        }else{
            $use_path = $this->templatePath;
        }
        
        if (!$use_path) {
            throw new Exception("Path not set");
        }
        
        
        $tfile = $use_path . $template;
        
        if (!file_exists($tfile)) {
            throw new Exception("Template does not exist: " . $tfile);
        }
        
        if ($cache !== FALSE) {
            
            if (!$this->cache_path) {
                throw new Exception("Cache path not set");
            }
            
            $cfile = $this->cache_path . $template . ".cache";
            
            if (file_exists($cfile)) {
                
                if ($cache === TRUE || filemtime($cfile) > time() - $cache) {
                    
                    $this->buffer = file_get_contents($cfile);
                    return $this;
                    
                } else {
                    
                    if (!$this->destroyCache($cfile)) {
                        throw new Exception("Failed to unlink cache file: " . $cfile);
                    }
                }
            }
        }
        
        ob_start();
        extract($this->storage);
        include $tfile;
        $buffer = ob_get_clean();
        
        if ($buffer === FALSE) {
            throw new Exception("Buffer not created");
        }
        
        $this->stripOutput($buffer);
        $this->buffer = $buffer;
        
        if ($cache !== FALSE) {
            $this->saveToCache($cfile, $buffer);
        }
        
        return $this;
    }
    
    // }}}
    
    public function show_view($template, $element = FALSE, $cache = FALSE){
        echo $this->render($template, $element, $cache);    
    }
    // {{{ saveToCache()
    
    /**
     * Save buffer to cache file
     *
     * @param string $file  a string representing path to target file.
     * @param string $content  a string representing content to save.
     * @return void
     * @throws Exception  if target directory for cache file does not
     *                    exist and cannot be created.
     * @throws Exception  if buffer cannot be written to file.
     */
    private function saveToCache($file, $content)
    {
        if (!is_dir(dirname($file))) {
            if (!mkdir(dirname($file), 0755, TRUE)) {
                throw new Exception("Could not create directory for cache file: " . dirname($file));
            }
        }
        
        if (!file_put_contents($file, $content)) {
            throw new Exception("Could not write buffer to file: " . $file);
        }
    }
    
    // }}}
    // {{{ destroyCache()
    
    /**
     * Unlink cached file
     *
     * @param string $file  a string representing path to file.
     * @return boolean
     * @throws Exception  if file does not exist.
     */
    public function destroyCache($file)
    {
        if (!file_exists($file)) {
            throw new Exception("File does not exist: " . $file);
        }
        
        return unlink($file);
    }
    
    // }}}
    // {{{ clear()
    
    /**
     * Clear current buffer
     *
     * @return Template  the template object.
     */
    public function clear()
    {
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        $this->buffer = NULL;
        return $this;
    }
    
    // }}}
    // {{{ __toString()
    
    /**
     * Return output buffer
     *
     * @return string
     * @throws Exception  if buffer is NULL.
     */
    public function __toString()
    {
        if (is_null($this->buffer)) {
            throw new Exception("No buffer to output");
        }
        
        return $this->buffer;
    }
    
    // }}}
    // {{{ stripOutput()
    
    /**
     * Strip output buffer accordingly
     *
     * @param string $buffer  the string to be processed.
     * @return void
     */
    private function stripOutput(&$buffer)
    {
        // if 1st bit is set, strip all empty lines
        if ($this->strip_output_level & 1) {
            $buffer = trim(preg_replace("/^[\s]*$[\r\n]*/m", " ", $buffer));
        }
        
        // if 2nd bit is set, strip all tab / spaces indentation
        if ($this->strip_output_level & 2) {
            $buffer = trim(preg_replace("/^[\t| ]/m", "", $buffer));
        }
        
        // if 3rd bit is set, strip all linebreaks
        if ($this->strip_output_level & 4) {
            $buffer = trim(preg_replace("/[\r|\n]/m", " ", $buffer));
        }
        
        // if 4th bit is set, strip all excess whitespace
        if ($this->strip_output_level & 8) {
            $buffer = trim(preg_replace("/ +/m", " ", $buffer));
        }
        
        $buffer = trim($buffer);
    }
    
    // }}}
    
    public function loadStylesheet($sheet){
        $styleString='<link rel="stylesheet" type="text/css" href="'.PATH_CSS.$sheet.'"/>';
        return $styleString;
    }
    
    public function loadJavascript($script){
        $styleString='<link rel="stylesheet" type="text/javascript" href="'.PATH_JS.$script.'"/>';
        return $styleString;
    }    
}

// }}}