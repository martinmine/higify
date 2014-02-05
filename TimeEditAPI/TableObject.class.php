<?php

class TableObject
{
	protected $id;
	protected $timeStart;
	protected $timeEnd;
	protected $courseCodes;
	protected $rooms;
	protected $lecturers;
	protected $classes;
	protected $lastChanged;

	__construct($id, $timeStart, $timeEnd, $courseCodes, 
		$rooms, $lectures, $classes, $lastChanged)
	{
		$this->id = $id;
		$this->timeStart = $timeStart;
		$this->timeEnd = $timeEnd;
		$this->courseCodes = $courseCodes;
		$this->rooms = $rooms;
		$this->lectures = $lectures;
		$this->classes = $classes;
		$this->lastChanged = $lastChanged;
	}

	function getID()
	{
		return $this->id;
	}

	function setID($id)
	{
		$this->id = $id;
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

	function getRooms()
	{
		return $this->rooms;
	}

	function setRooms($rooms)
	{
		$this->rooms = $rooms;
	}

	function getLectures()
	{
		return $this->lectures;
	}

	function setLectures($lectures)
	{
		$this->lectures = $lectures;
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