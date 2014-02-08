<?php

class TimeTableIterator implements Iterator
{
	private $tableKeys;
	private $position;
	private $timeTable;
	private $itemCount;
	
	public function __construct($timeTable)
	{
		$this->timeTable = $timeTable;
		$this->tableKeys = $timeTable->getTableKeys();
		$this->itemCount = count($this->tableKeys);
		$this->position = 0;
	}
	
	private function getIndex()
	{
		return $this->tableKeys[$this->position];
	}
	
	public function rewind() 
	{
		$this->position = 0;
	}

	public function current() 
	{
		return $this->timeTable->getItem($this->getIndex());
	}

	public function key() 
	{
		return $this->position;
	}

	public function next() 
	{
		$this->position++;
	}

	public function valid() 
	{
		return $this->position < $this->itemCount;
	}
}

?>