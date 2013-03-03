<?php

abstract class Result implements Iterator, Countable
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
    abstract protected function __construct($result);
}

?>