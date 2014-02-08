<?php

class TimeTableIterator implements Iterator
{
	/**
	 * Array of keys in the TimeTable
	 * @var Array
	 */
	private $tableKeys;

	/**
	 * Which position we are in the TimeTable
	 * @var integer
	 */
	private $position;

	/**
	 * The TimeTable which we are an iterator for
	 * @var TimeTable
	 */
	private $timeTable;
	/**
	 * How many items there are in the time table
	 * @var integer
	 */
	private $itemCount;
	
	/**
	 * Prepares an interator for a TimeTable
	 * @param TimeTable $timeTable What TimeTable this is an iterator for
	 */
	public function __construct($timeTable)
	{
		$this->timeTable = $timeTable;
		$this->tableKeys = $timeTable->getTableKeys();
		$this->itemCount = count($this->tableKeys);
		$this->position = 0;
	}
	
	/**
	 * Gets the index key at the current position in the array
	 * @return integer or string, this is PHP, who knows?! The key at our position
	 */
	private function getIndex()
	{
		return $this->tableKeys[$this->position];
	}
	
	/**
	 * Resets the itertor
	 */
	public function rewind() 
	{
		$this->position = 0;
	}

	/**
	 * Returns the item at the current position
	 * @return TableObject The TableObject for the current position
	 */
	public function current() 
	{
		return $this->timeTable->getItem($this->getIndex());
	}

	/**
	 * Gets the key for our current position
	 * @return integer The index position for the iterator
	 */
	public function key() 
	{
		return $this->position;
	}

	/**
	 * Increments the iterator for next value
	 */
	public function next() 
	{
		$this->position++;
	}

	/**
	 * Returs true if we are not done iterating, otherwise false
	 * @return boolean True if we can still iterate, otherwise false
	 */
	public function valid() 
	{
		return $this->position < $this->itemCount;
	}
}

?>