<?php

class CoreController
{
    private $modelname='UNSET';
    private $model_short_name='UNSET';
    protected $hasModel=true;
    protected $customModel=false;
    protected $renderArgs = array();
    protected $Registry;
    protected $Template;
    protected $modeldata = array();

    function __construct($renderpath, $actionview)
    {
        $this->init($renderpath, $actionview);
    }
    
    protected function init($renderpath, $actionview)
    {
        $this->Registry = Registry::getInstance();
        $this->Template = $this->Registry->Template;   
   
        $backtrace = debug_backtrace();
        $previous_actions = $backtrace[2];
        $this->renderArgs['renderpath'] = $renderpath.DS;
        $this->renderArgs['view'] = $actionview.'.php';
        $this->renderArgs['basepath'] = 'app';
        $this->renderArgs['basetemplate']='default.php';
        $this->renderArgs['recursive']='first';

        if($this->hasModel){
           
            if(!$this->customModel){
                $model_name=$renderpath;
                $this->modelname=$this->loadModel($model_name);
            }else{
                $model_name=$this->customModel;
                $this->modelname=$this->loadModel($model_name);                
            }   
        }        
    }

    protected function loadModel($model_name)
    {
        $modelname='UNSET';
        if(is_readable(PATH_MODEL.$model_name.'_model.php'))
        {
           $modelname= ucfirst($model_name).'Model';
           require_once(PATH_MODEL.$model_name.'_model.php');
        }
 
        if(is_readable(PATH_CORE_MODEL.$model_name.'_model.php'))
        {
           $modelname= ucfirst($model_name).'Model';
           require_once(PATH_CORE_MODEL.$model_name.'_model.php');
        }
        
        if($modelname != 'UNSET'){
            $tablename= strtolower(str_replace('Model', '', $modelname));
            $this->model_short_name= ucfirst(strtolower($model_name));
            $model_short_name=$this->model_short_name;
            $this->$model_short_name = new $modelname($tablename);
            return $modelname;            
        }
    }

    private function __set($name, $value)
    {
        $this->modeldata[$name]  = $value;
    }    

    private function __get($name)
    {
        return $this->modeldata[$name];
    }     
    
    function render($args = array())
    {
        $seo_robots_index=true;
        $seo_robots_follow=true;

        if(defined('SEO_DEFAULT_INDEX')){
            echo 'aaaaaa';
            $seo_robots_index=SEO_DEFAULT_INDEX;
        }else{
            echo 'bbbbb';
        }
        if(defined('SEO_DEFAULT_FOLLOW')){
            $seo_robots_follow=SEO_DEFAULT_FOLLOW;
        } 
        
        if(array_key_exists('redirect', $args)){
           header( 'Location: '.$args['redirect'] ) ;
        }
        
        $view=$this->renderArgs;
        $view['recursive']='second';
        $args['View']=$view;
        $args['Template']=$this->Template;
        $args['Session']=$this->Registry->Session;
        $args['SEO_Header_index']=$seo_robots_index;
        $args['SEO_Header_follow']=$seo_robots_follow;
        
        foreach($args as $key=>$value)
        {
            $this->Template->set($key, $value);
        }

        echo $this->Template->render($this->renderArgs); 
    }
    
    function showby($fieldname, $value, $model='DEFUALT')
    {
        if($model=='DEFUALT'){
            $model_shortname=$this->model_short_name;
            $model=$this->$model_shortname;
            $model->load($fieldname, $value);
            $this->render(array($model_shortname => $model));            
        }
    }
    
}
?>
