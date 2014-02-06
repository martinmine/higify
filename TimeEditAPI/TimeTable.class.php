<?php

class TimeTable implements Iterator
{
	protected $tableObjects;
	protected $count;

	public function __construct()
	{
		$this->tableObjects = Array();
		$this->count = 0;
	}

	public function addObject($object)
	{
		$this->tableObjects[] = $object;
	}

	public function addObjectWithID($object, $objectID)
	{
		$this->tableObjects[$objectID] = $object;
	}

	public function getItem($objectID)
	{
		return $this->tableObjects[$objectID];
	}

	public function removeItem($objectID)
	{
		return $this->tableObjects[$objectID];
	}

	public function count()
	{
		return $this->count;
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