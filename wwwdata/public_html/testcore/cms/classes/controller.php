<?php

/**
 * ControllerBase class
 *
 * Define functions and variable that should be present in all controllers here.
 */
class ControllerBase
{
    /**
     * @var array  an array holding any params passed by the router.
     */
    protected $parameters = array();
    protected $Template;
    protected $Registry;
    protected $Session;

    /**
     * Contructor
     *
     * @param Registry $registry  the application registry object.
     * @param array $params  an array with params passed by router.
     * @return void
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
        $this->Template = Registry::getInstance()->Template; 
        $this->Registry = Registry::getInstance();
        $this->Session = Session::getInstance();
    }

    public function index(){}
    public function edit(){}
    public function show(){}
    public function add(){}
    public function delete(){}
}
