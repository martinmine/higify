<?php
require_once('TimeTableIterator.class.php');
class TimeTable implements JsonSerializable
{
	/**
	 * All the TableObjects 
	 * @var Array
	 */
	private $tableObjects;

	/**
	 * How many items are in the TimeTable
	 * @var integer
	 */
	private $count;
	
	/**
	 * Creates an empty TimeTable
	 */
	public function __construct()
	{
		$this->tableObjects = Array();
		$this->count = 0;
	}

	/**
	 * Adds an item without an ObjectID to the TimeTable
	 * @param TableObject $object New object to add to TimeTable
	 */
	public function addObject($object)
	{
		$this->tableObjects[$this->count++] = $object;
	}

	/**
	 * Adds an object to the TimeTable which has an ID
	 * @param TimeTable $object   New object to add
	 * @param integer   $objectID The ObjectID
	 */
	public function addObjectWithID($object, $objectID)
	{
		$this->tableObjects[$objectID] = $object;
		$this->count++;
	}
	
	/**
	 * Returns an array with all the keys and index number
	 * @return Array array_keys
	 */
	public function getTableKeys()
	{
		return array_keys($this->tableObjects);
	}

	/**
	 * Gets an item from the time table by ObjectID
	 * @param  integer $objectID The objectID for the object we are looking for
	 * @return TableObject       TableObject which has the objectID
	 */
	public function getItem($objectID)
	{
		return $this->tableObjects[$objectID];
	}

	/**
	 * Removes an item from the TimeTable by object ID
	 * @param  integer $objectID The ID of the object to Remove
	 */
	public function removeItemByID($objectID)
	{
		return $this->tableObjects[$objectID];
	}

	/**
	 * @return integer Count of elements in the time table
	 */
	public function count()
	{
		return $this->count;
	}
	
	/**
	 * Gets the iterator for the TimeTable object
	 * @return TimeTableIterator Iterator for this object
	 */
	public function getIterator()
	{
		return new TimeTableIterator($this);
	}
	
	/**
	 * Serializes the TimeTable for JSON (required by JsonSerializable)
	 * @return Array Represents the content for the JSON serializer
	 */
	public function jsonSerialize()
	{
		return array(
			'count' => $this->count, 
			'objects' => $this->tableObjects
			);
    }
}
?>