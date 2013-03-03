<?php

class Model{
	var $sql_builder;
	protected $properties_cached = array();

    public function load($table, $field, $param)
    {
		$sql_builder = new SQLBuilder();
		$rows = $sql_builder->select(array(	'tables' => array($table),
											'cols'	 => array("*"),
											'where'  => array($field => $param)));
		
		foreach ($rows->current() as $key => $value) {
			$this->properties_cached[$key] = $value;
		}
    }
	
    public function delete()
    {
		throw new Exception("TODO: Functie schrijven");
        $DB = Registry::getInstance()->DB;	
        $query = sprintf(
            "UPDATE %s
                SET is_deleted = TRUE
              WHERE id = %u
              LIMIT 1"
            , $this->tablename
            , $this->id
        );
        
        return $DB->alter($query);
    }
	
    public function __unset($key)
    {
		throw new Exception("TODO: Functie schrijven");
        $DB = Registry::getInstance()->DB;
        
        $query = sprintf(
            "UPDATE %s
                SET $key = NULL
              WHERE id = %u
              LIMIT 1"
            , $this->tablename
            , $this->id
        );
        
        if ($DB->alter($query)) {
            unset($this->properties_cached[$key]);
        }
    }
    
    public function __set($key, $value)
    {
		throw new Exception("TODO: Functie schrijven");
        $DB = Registry::getInstance()->DB;
        
        $query = sprintf(
            "UPDATE %s
                SET $key = '%s'
              WHERE id = %u
              LIMIT 1"
            , $this->tablename
            , $DB->escape($value)
            , $this->id
        );
        
        if ($DB->alter($query)) {
            $this->properties_cached[$key] = $value;
        }
    }
    
    public function __get($key)
    {
        if (array_key_exists($key, $this->properties_cached)) {
            return $this->properties_cached[$key];
        }      
    }

    public function read()
    {
		return $this->properties_cached;
    }	
}

class SQLBuilder
{
	/**
	 * Generate complete UPDATE qeury. The update statement will only be affected on only one table.
	 *	@params 	array(	'tables' 	=> array("printon"),
	 *						'where' 	=> array("job" => "PicklistJobs"),
	 *						'set' 		=> array("name" => "printer"));
	 *	@params Array; needs to have sub-arrays 'tables', 'where', 'set'
	 **/		
	public function update($params){
		$DB = Registry::getInstance()->DB;
		$prefix = "UPDATE ";
		$p = $this->clean($params);
		$statement = $prefix." ".$params['tables'][0]." ".$this->genSet($p['set']).$this->genWhere($p['where']);	
		$DB->alter($statement);	
	}
	/**
	 * Generate complete SELECT qeury. The select statement will only be affected on only one table.
	 *	@params 	array(	'tables' 	=> array("printon"),
	 *						'cols' 		=> array("*"),
	 *						'where' 	=> array("name" => "printer"));
	 *	@params Array; needs to have sub-arrays 'cols', 'tables', 'where', 'set'
	 **/	
	public function select($params){
		$DB = Registry::getInstance()->DB;
		$prefix = "SELECT ";
		$p = $this->clean($params);
		$statement = $prefix." ".$this->genFrom($p['cols'])." ".$this->genTable($p['tables']).$this->genWhere($p['where']);	
		return $DB->select($statement);	
	}	

	/**
	 * Generate complete INSERT qeury. The insert statement will only be affected on only one table.
	 *	@params 	array(	'tables' 	=> array("printon"),
	 *						'set' 		=> array("name" => "printer"));
	 *	@params Array; needs to have sub-arrays 'cols', 'tables', 'where', 'set'
	 **/	
	public function insert($params){
		$DB = Registry::getInstance()->DB;
		$prefix = "INSERT ";
		$p = $this->clean($params);	
		$statement = $prefix." ".$params['tables'][0]." ".$this->genSet($p['set']);	
		$DB->exec($statement);	
	}	
	
	/**
	 * Clean SQL params.
	 *
	 **/
    public function clean($params)
    {
		$SQL=new SQL();

		if(array_key_exists('set', $params)){
			foreach($params['set'] as $key=>$a){
				//Remove some special characters which are not supported.
				for($i=162;$i<175;$i++){ 
					if(strpos ($a , chr($i)) !==false){
						$a = str_replace(chr($i),"",$a);
					}
				}			
				$params['set'][$key] = $SQL->real_escape_string($a);
			}		
		}	

		if(array_key_exists('where', $params)){
			foreach($params['where'] as $key=>$a){
				$params['where'][$key] = $SQL->real_escape_string($a);
			}		
		}		
		
		$params['where'] = $SQL->quoteArr($params['where']); //Set qoutes on WHERE clause
		$params['set'] = $SQL->quoteArr($params['set']); //Set qoutes on WHERE clause
		return $params;
    }
	
	/**
	 * Generate WHERE clause.
	 *
	 **/	
	public function genWhere($array){
		$where = null;
		foreach($array as $key=>$a)
		{
			if(is_numeric($a)){
				$comp = " = "; //in case nummeric: use '='
			}else{
				$comp = " LIKE "; //in case string: use 'LIKE'
			}
			if(isset($where)){
				$where .= " AND ".$key.$comp.$a;
			}else{
				$where = $key.$comp.$a;
			}			
		}
		
		if(isset($where)){
			$where = " WHERE ".$where;
		}else{
			$where="";
		}
		
		return $where;
	}
	
	/**
	 * Generate SET clause.
	 *
	 **/	
	public function genSet($array){
		$set = null;
		foreach($array as $key=>$a)
		{
			if(isset($set)){
				$set .= ", ".$key."=".$a;
			}else{
				$set = $key."=".$a;
			}			
		}
		return "SET ".$set;
	}

	/**
	 * Generate FROM clause.
	 *
	 **/	
	public function genFrom($array){
		$from = null;
		foreach($array as $key=>$a)
		{
			if(isset($from)){
				$from .= ", ".$a;
			}else{
				$from = $a;
			}			
		}
		return $from." FROM ";
	}	

	/**
	 * Generate TABLE clause.
	 *
	 **/	
	public function genTable($array){
		$table = null;
		foreach($array as $key=>$a)
		{
			if(isset($table)){
				$table .= ", ".$a;
			}else{
				$table = $a;
			}			
		}
		return $table;
	}
}

class SQL 
{ 

	function real_escape_string($s){
		return mysql_real_escape_string($s);
	}
    /** 
     * Remove unnecessary string in a sql query 
     * @param string $s String 1 
     * @param string $s2 String need to be removed 
     * @return string 
     * @access private 
     **/ 
    function trim($s,$s2) { 
        if (substr($s , strlen($s) - strlen($s2)) == $s2) $s = substr($s , 0 , strlen($s) - strlen($s2)); 
        return $s; 
    } 
	
    /** 
     * Quote a SQL value 
     * @param array
     * @return array 
     **/ 
    function quoteArr($array) { 
		foreach($array as $key=>$a)
		{
			if(!is_numeric($array[$key])){
				$array[$key] = $this->quote($a);
			}
		}
		return $array;
    } 
	
    /** 
     * Quote a SQL value 
     * @param string $s String need to be quoted 
     * @return string 
     **/ 
    function quote($s) { 
        return "'".str_replace('\\"', '"', addslashes($s))."'"; 
    } 

    /** 
     * Return SQL Time 
     * @return string 
     **/ 
    function time($value,$format="DATE") { 
        $f = ''; 
        switch (strtoupper($format)) { 
            case 'DATE': 
            $f = 'Y-m-d'; 
            break; 
            case 'TIME': 
            $f = 'H:i:s'; 
            break; 
            case 'DATETIME': 
            default: 
            $f = 'Y-m-d H:i:s'; 
            break; 
        } 
        return date($f , $value); 
    } 
} 



?>
