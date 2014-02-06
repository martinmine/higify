<?php

class TableObject
{
	protected $id;
	protected $timeStart;
	protected $timeEnd;
	protected $courseCodes;
	protected $room;
	protected $lecturer;
	protected $classes;
	protected $lastChanged;

	/*public function __construct($id, $timeStart, $timeEnd, $courseCodes, 
		$room, $lecturer, $classes, $lastChanged)
	{
		$this->id = intval($id);
		$this->timeStart = $timeStart;
		$this->timeEnd = $timeEnd;
		$this->courseCodes = $courseCodes;
		$this->room = $room;
		$this->lecturer = $lecturer;
		$this->classes = $classes;
		$this->lastChanged = $lastChanged;
	}*/

	function getID()
	{
		return $this->id;
	}

	function setID($id)
	{
		$this->id = intval($id);
	}

	function getTimeStart()
	{
		return $this->timeStart;
	}

	function setTimeStart($timeStart)
	{
		$this->timeStart = $timeStart;
	}

	function getTimeEnd()
	{
		return $this->timeEnd;
	}

	function setTimeEnd($timeEnd)
	{
		$this->timeEnd = $timeEnd;
	}

	function getCourseCodes()
	{
		return $this->courseCodes;
	}

	function setCourseCodes($courseCode)
	{
		$this->courseCode = $courseCode;
	}

	function getRoom()
	{
		return $this->room;
	}

	function setRoom($room)
	{
		$this->room = $room;
	}

	function getLecturer()
	{
		return $this->lecturer;
	}

	function setLecturer($lecturer)
	{
		$this->lecturer = $lecturer;
	}

	function getClasses()
	{
		return $this->classes;
	}

	function setClasses($classes)
	{
		$this->classes = $classes;
	}
	
	function getLastChanged()
	{
		return $this->lastChanged;
	}

	function setLastChanged($lastChanged)
	{
		$this->lastChanged = $lastChanged;
	}
}

?>