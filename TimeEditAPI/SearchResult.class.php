<?php

class SearchResult
{
	/**
	 * What type the search returned, specified in the ObjectType class
	 * @var integer
	 */
	private $type;
	
	/**
	 * ID unique for this person/room
	 * @var integer
	 */
	private $id;
	
	/**
	 * Info for this item, can be name on lecturer or room code
	 * @var string
	 */
	private $info;
	
	/**
	 * Longer description, can be class name 
	 * @var string
	 */
	private $description;
	
	/**
	 * Creates a new SearchResult object
	 * @param integer $type        The type of search result, defined in ObjectType class
	 * @param integer $id          Unique ID for this object
	 * @param string  $info        Name of lecturer, room name, etc.
	 * @param string  $description Description of course eg. (Software developmet)
	 */
	public function __construct($type, $id, $info, $description)
	{
		$this->type = $type;
		$this->id = $id;
		$this->info = $info;
		$this->description = $description;
	}
	
	/**
	 * Gets the type of this search object
	 * @return integer The object type ID
	 */
	public function getType()
	{
		return $this->type;
	}
	
	/**
	 * Gets the unique object ID for this object
	 * @return integer The object ID
	 */
	public function getID()
	{
		return $this->id;
	}
	
	/**
	 * Gets the info for this object (lecture name, course code)
	 * @return mixed
	 */
	public function getInfo()
	{
		return $this->info;
	}
	
	/**
	 * Gets the description for this search result, can be 
	 * course description (Algorithmic programming), or 
	 * long name of a class (Software development)
	 * @return string The description
	 */
	public function getDescription()
	{
		return $this->description;
	}
}

?>