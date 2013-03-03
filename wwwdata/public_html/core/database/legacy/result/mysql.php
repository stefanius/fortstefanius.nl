<?php

class ResultMySQL extends Result
{
    
    /**
     * @var resource $result a resource identifying the result set.
     * @var mixed $row a mixed variable holding the current row as object or array.
     * @var integer $rows an integer with how many rows the result set contains.
     * @var string $fetch_function a string representation of the function to use for fetching.
     */
    private $result;
    private $row;
    private $rows;
    public $fetch_function = "mysql_fetch_object";
    
    /**
     * Constructor
     *
     * @param resource $result  a resource identifying the result set.
     * @param string $fetch_as  which method to use for fetching.
     * @return void
     */
    public function __construct($result)
    {
        $this->result = $result;
        $this->rows = mysql_num_rows($result);
    }
    
    public function rewind()
    {
        if ($this->rows) {
            $this->cur = 0;
            mysql_data_seek($this->result, $this->cur);
        }
    }
    
    public function key()
    {
        return $this->cur;
    }
    
    public function current()
    {
        if ($this->rows) {
            mysql_data_seek($this->result, $this->cur);
            $f = $this->fetch_function;
            return $f($this->result);
        }
    }
    
    public function next()
    {
        $this->cur++;
    }
    
    public function valid()
    {
        if (!$this->rows) {
            return FALSE;
        }
        
        return $this->cur < $this->rows;
    }
    
    public function count()
    {
        return (integer) $this->rows;
    }
}

?>