<?php

class TimeTable implements Iterator
{
	protected $tableObjects;

	public function __construct()
	{
		$this->tableObjects = new Array();
	}

	public function addObject($objectID, $object)
	{
		$this->tableObjects[] = $object;
	}

	public function getItem($objectID)
	{
		return $tableObjects[$objectID];
	}

	public function removeItem($objectID)
	{
		return $tableObjects[$objectID];
	}

	// Functions which are required to be implemented by Iterator 
	public function rewind()
	{
		reset($this->var);
	}

	public function current()
	{
		return current($this->var);
	}

	public function key() 
	{
		return key($this->var);
	}

	public function next() 
	{
		return next($this->var);
	}

	public function valid()
	{
		return key($this->var);
	}



}
?>