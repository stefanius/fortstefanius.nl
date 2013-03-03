<?php
class SQLDriverMySQL extends Database
{
    /**
     * @var resource $link a resource representing the database connection.
     * @var string $database a string with the currently selected database.
     * @var boolean $debug a boolean defining whether debug mode is on or off.
     * @var array $queries an array holding all queries executed and their timing.
     */
    private $link;
    private $database;
    public $debug = FALSE;
    private $queries = array();
    
    /**
     * Connect
     *
     * Establishes the link with the MySQL server instance and attempts
     * to select the database passed to the constructor (if not null).
     *
     * @param string $hostname  a string with the hostname.
     * @param string $username  a string with the username.
     * @param string $password  a string with the (plain) password.
     * @param string $database  a string with the database to select.
     * @return void
     * @throws Exception  if connection to server could not be made.
     */
    public function connect($hostname, $username, $password, $database)
    {
        $link = mysql_connect($hostname, $username, $password);
        
        if ($link === FALSE) {
            $errstr  = "Could not connect to server: " . $hostname . PHP_EOL;
            $errstr .= "Server returned: " . mysql_errno() . ": " . mysql_error();
            throw new Exception($errstr);
        }

        if (mysql_select_db($database, $link) === FALSE) {
            $errstr  = "Could not select database: " . $database . PHP_EOL;
            $errstr .= "Server returned: " . mysql_errno($link) . ": " . mysql_error($link);
            throw new Exception($errstr);
        }
		
        $this->link = $link;
        $this->database = $database;		
    }
    
    /**
     * Run select query (on current database, or given)
     *
     * This function should only be used in the case of SELECT queries, due
     * to the nature of its return value. A MySQLResult object will be
     * generated, which can be looped in a while/foreach structure just like
     * any regular array.
     *
     * @param string $sql  a string with with the sql to execute.
     * @param string $database  a string with the database name to run query on.
     * @return Result  a result object.
     * @throws Exception  if query could not be executed.
     */
    public function select($sql)
    {   
        if ($this->debug === TRUE) {
            $start = microtime(TRUE);
        }
        
        $result = mysql_query($sql, $this->link);
        
        if ($result === FALSE) {
            $errstr  = "Invalid query: " . $sql . PHP_EOL;
            $errstr .= "Server returned: " . mysql_errno($this->link) . ": " . mysql_error($this->link);
            throw new Exception($errstr);
        }
        
        if ($this->debug === TRUE) {
            $end = microtime(TRUE);
            $time = sprintf("%.8F", $end - $start);
            $this->queries[] = array(
                "sql" => $sql,
                "sec" => $time
            );
        }
        
        $Result = new ResultMySQL($result);
        $Result->rewind();
        return $Result;
    }
    
    /**
     * Run insert query (on current database, or given)
     *
     * This function should only be used in the case of INSERT queries,
     * as it will attempt to return the ID generated for the inserted row.
     *
     * @param string $sql  a string with with the sql to execute.
     * @param string $database  a string with the database name to run query on.
     * @return integer  ID generated by AUTO_INCREMENT column for inserted row.
     * @throws Exception  if query could not be executed.
     */
    public function insert($sql)
    {   
        if ($this->debug === TRUE) {
            $start = microtime(TRUE);
        }
        
        $result = mysql_query($sql, $this->link);
        
        if ($result === FALSE) {
            $errstr  = "Invalid query: " . $sql . PHP_EOL;
            $errstr .= "Server returned: " . mysql_errno($this->link) . ": " . mysql_error($this->link);
            throw new Exception($errstr);
        }
        
        if ($this->debug === TRUE) {
            $end = microtime(TRUE);
            $time = sprintf("%.8F", $end - $start);
            $this->queries[] = array(
                "sql" => $sql,
                "sec" => $time
            );
        }
        
        return mysql_insert_id($this->link);
    }
    
    /**
     * Run alter query (on current database, or given)
     *
     * This function should be used for UPDATE or DELETE statements. It will
     * return an integer count of the amount of affected rows.
     *
     * @param string $sql  a string with with the sql to execute.
     * @param string $database  a string with the database name to run query on.
     * @return integer  an integer of how many rows have been affected.
     * @throws Exception  if query could not be executed.
     */
    public function alter($sql)
    {   
        if ($this->debug === TRUE) {
            $start = microtime(TRUE);
        }
        
        $result = mysql_query($sql, $this->link);
        
        if ($result === FALSE) {
            $errstr  = "Invalid query: " . $sql . PHP_EOL;
            $errstr .= "Server returned: " . mysql_errno($this->link) . ": " . mysql_error($this->link);
            throw new Exception($errstr);
        }
        
        if ($this->debug === TRUE) {
            $end = microtime(TRUE);
            $time = sprintf("%.8F", $end - $start);
            $this->queries[] = array(
                "sql" => $sql,
                "sec" => $time
            );
        }
        
        return mysql_affected_rows($this->link);
    }

    /**
     * Run exec query (on current database, or given)
     *
     * This function should be used for statements of which we do not care
     * about the result / outcome.
     *
     * @param string $sql  a string with with the sql to execute.
     * @param string $database  a string with the database name to run query on.
     * @return integer  an integer of how many rows have been affected.
     * @throws Exception  if query could not be executed.
     */
    public function exec($sql)
    {
        if ($this->debug === TRUE) {
            $start = microtime(TRUE);
        }
        
        $result = mysql_query($sql, $this->link);
        
        if ($result === FALSE) {
            $errstr  = "Invalid query: " . $sql . PHP_EOL;
            $errstr .= "Server returned: " . mysql_errno($this->link) . ": " . mysql_error($this->link);
            throw new Exception($errstr);
        }
        
        if ($this->debug === TRUE) {
            $end = microtime(TRUE);
            $time = sprintf("%.8F", $end - $start);
            $this->queries[] = array(
                "sql" => $sql,
                "sec" => $time
            );
        }
    }
    
    /**
     * Strips newlines, tabs and excessive whitespace from the string
     *
     * @param string $string  the string to be escaped.
     * @return string $string  the escaped string.
     */
    public function clean($string)
    {
        // strip all tab indentation and newlines, replace with spaces
        $string = preg_replace("/[\r|\n|\t]/m", " ", $string);
        
        // strip all empty lines
        $string = preg_replace("/^[\s]*$[\r\n]*/m", " ", $string);
        
        // strip all excess whitespace
        $string = preg_replace("/ +/m", " ", $string);
        
        // trim remainder
        return trim($string);
    }
    
    /**
     * Returns all queries executed
     *
     * @return array  an array with all queries executed so far.
     * @throws Exception  if debug mode is turned off.
     */
    public function getQueries()
    {
        if ($this->debug === FALSE) {
            throw new Exception("Debug mode is turned off");
        }
        
        return $this->queries;
    }
    
    public function addCreatedField($table)
    {
        return $this->alter("ALTER TABLE  `".$table."` ADD  `created` DATETIME NOT NULL COMMENT  'Date/Time created'");
    }
    
    public function addModifiedField($table)
    {
        return $this->alter("ALTER TABLE  `".$table."` ADD  `modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT  'Date/Time modified'");
    }
}

?>