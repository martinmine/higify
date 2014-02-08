<?php

class TableObject implements JsonSerializable
{
	private $id;
	private $timeStart;
	private $timeEnd;
	private $courseCodes;
	private $room;
	private $lecturer;
	private $classes;
	private $lastChanged;

	const DATE_TIME_FORMAT = 'Y-m-d H:i:s';
	
	public function getID()
	{
		return $this->id;
	}

	public function setID($id)
	{
		$this->id = intval($id);
	}

	public function getTimeStart()
	{
		return $this->timeStart;
	}
	
	public function getTimeStartFormated()
	{
		return $this->timeStart->format(self::DATE_TIME_FORMAT);
	}

	public function setTimeStart($timeStart)
	{
		$this->timeStart = $timeStart;
	}

	public function getTimeEnd()
	{
		return $this->timeEnd;
	}

	public function getTimeEndFormated()
	{
		return $this->timeEnd->format(self::DATE_TIME_FORMAT);
	}
	
	public function setTimeEnd($timeEnd)
	{
		$this->timeEnd = $timeEnd;
	}

	public function getCourseCodes()
	{
		return $this->courseCodes;
	}

	public function setCourseCodes($courseCode)
	{
		$this->courseCodes = $courseCode;
	}

	public function getRoom()
	{
		return $this->room;
	}

	public function setRoom($room)
	{
		$this->room = $room;
	}

	public function getLecturer()
	{
		return $this->lecturer;
	}

	public function setLecturer($lecturer)
	{
		$this->lecturer = $lecturer;
	}

	public function getClasses()
	{
		return $this->classes;
	}

	public function setClasses($classes)
	{
		$this->classes = $classes;
	}
	
	public function getLastChanged()
	{
		return $this->lastChanged;
	}
	
	public function getLastChangedFormated()
	{
		return $this->lastChanged->format(self::DATE_TIME_FORMAT);
	}

	public function setLastChanged($lastChanged)
	{
		$this->lastChanged = $lastChanged;
	}
	
	public function match($tableObject)
	{
		$keys = array_keys($this->courseCodes[0]);
				
		if ($this->timeStart == $tableObject->timeStart && $this->timeEnd == $tableObject->timeEnd
			&& $tableObject->courseCodes[0] == $keys[0] && $this->room == $tableObject->room)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function jsonSerialize()
	{
		return array(
			'id' => $this->id,
			'timeStart' => $this->getTimeStartFormated(),
			'timeEnd' => $this->getTimeEndFormated(),
			'lastChanged' => $this->getLastChangedFormated(),
			'courseCodes' => $this->courseCodes,
			'room' => $this->room,
			'lecturer' => $this->lecturer,
			'classes' => $this->classes
			);
	}
}

?>