<?php
require_once('TimeTableIterator.class.php');
class TimeTable implements JsonSerializable
{
	private $tableObjects;
	private $count;
	
	public function __construct()
	{
		$this->tableObjects = Array();
		$this->count = 0;
	}

	public function addObject($object)
	{
		$this->tableObjects[$this->count++] = $object;
	}

	public function addObjectWithID($object, $objectID)
	{
		$this->tableObjects[$objectID] = $object;
		$this->count++;
	}
	
	public function getTableKeys()
	{
		return array_keys($this->tableObjects);
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
	
	public function isValid($i)
	{
		return isset($this->tableObjects[$i]);
	}
	
	public function getIterator()
	{
		return new TimeTableIterator($this);
	}
	
	public function jsonSerialize()
	{
		return array(
			'count' => $this->count, 
			'objects' => $this->tableObjects
			);
    }
}
?>