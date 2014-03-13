<?php

/**
 * Holds all the data for one TableObject
 */
class TableObject implements JsonSerializable
{
	/**
	 * ID of the TableObject
	 * @var integer
	 */
	private $id;

	/**
	 * When the period for the TableObject begins
	 * @var DateTime
	 */
	private $timeStart;

	/**
	 * When the perid for the TableObject ends
	 * @var DateTime
	 */
	private $timeEnd;

	/**
	 * The course codes and with the long-name description of the course
	 * @var Associative array string=>string if the parser got both 
	 *      the course ID (eg. IMT2021) and the course name (Algorithmic methods), 
	 *      otherwise array of strings
	 */
	private $courseCodes;

	/**
	 * Location of the TableObject (Room number eg. K105)
	 * @var string
	 */
	private $room;

	/**
	 * Who the lecturer is for this period
	 * @var Array of strings
	 */
	private $lecturer;

	/**
	 * Who attends the course
	 * @var Array of strings
	 */
	private $classes;

	/**
	 * Last time the data was updated server-side (TimeEdit)
	 * @var DateTime
	 */
	private $lastChanged;

    /**
     * Indicates if this ID came from an incremental counter (CSV parser)
     * @var boolean
     */
    private $incrementalID;
    
	/**
	 * The format which the DateTime shall be displayed as on XML/getTimeFormated
	 */
	const DATE_TIME_FORMAT = 'Y-m-d H:i:s';
	
    
    public function __construct()
    {
        $this->incrementalID = false;
    }
	/**
	 * Gets the ID of the object
	 * @return integer ID of object
	 */
	public function getID()
	{
		return $this->id;
	}

	/**
	 * Sets the ID
	 * @param integer $id the new ID
	 */
	public function setID($id)
	{
		$this->id = intval($id);
	}

	/**
	 * Gets the start time of the TableObject
	 * @return DateTime Timestamp of when it starts
	 */
	public function getTimeStart()
	{
		return $this->timeStart;
	}
	
	/**
	 * Formats the start DateTime
	 * @return string The start time for the object formated according to the DATE_TIME_FORMAT
	 *         const
	 */
	public function getTimeStartFormated()
	{
		return $this->timeStart->format(self::DATE_TIME_FORMAT);
	}

	/**
	 * Sets the time for when the TableObject begins
	 * @param DateTime $timeStart when the TableObject shall begin
	 */
	public function setTimeStart($timeStart)
	{
		$this->timeStart = $timeStart;
	}

	/**
	 * Gets the time DateTime for when the TableObject begins
	 * @return DateTime When the TableObject ends
	 */
	public function getTimeEnd()
	{
		return $this->timeEnd;
	}

	/**
	 * Formats the timestamp for when the table object is done
	 * @return string Formated according to DATE_TIME_FORMAT
	 */
	public function getTimeEndFormated()
	{
		return $this->timeEnd->format(self::DATE_TIME_FORMAT);
	}
	
	/**
	 * Sets the timestamp for when the table object ends
	 * @param DateTime $timeEnd When the TableObject ends
	 */
	public function setTimeEnd($timeEnd)
	{
		$this->timeEnd = $timeEnd;
	}

	/**
	 * Gets the course codes
	 * @return Associative array or normal array The course codes assigned
	 *         to the table object
	 */
	public function getCourseCodes()
	{
		return $this->courseCodes;
	}

	/**
	 * Sets the course codes
	 * @param Array or associative array $courseCode with all the codes/info
	 */
	public function setCourseCodes($courseCode)
	{
        
		$this->courseCodes = $courseCode;
	}

	/**
	 * Gets the room location
	 * @return string Room number of the TableObject 
	 */
	public function getRoom()
	{
		return $this->room;
	}

	/**
	 * Changes the assigned room for the TableObject
	 * @param string $room The new room
	 */
	public function setRoom($room)
	{
		$this->room = $room;
	}

	/**
	 * Gets the lectureres assigned to the TableObject/class
	 * @return Array of the lectures last name
	 */
	public function getLecturer()
	{
		return $this->lecturer;
	}

	/**
	 * Changes the lecturers assigned to this TableObject
	 * @param Array $lecturer new lecturers
	 */
	public function setLecturer($lecturer)
	{
		$this->lecturer = $lecturer;
	}

	/**
	 * Gets the classes which attends this TableObject/event
	 * @return Array of class codes
	 */
	public function getClasses()
	{
		return $this->classes;
	}

	/**
	 * Changes the lassses who attends this TableObject/event
	 * @param Array $classes Holds all the classes
	 */
	public function setClasses($classes)
	{
		$this->classes = $classes;
	}
	
	/**
	 * Gets the date and time for when the object was last modified on TimeEdit
	 * @return DateTime when it was modified
	 */
	public function getLastChanged()
	{
		return $this->lastChanged;
	}
	
	/**
	 * Gets the date/time for when the TableObject was last modified according to
	 * the DATE_TIME_FORMAT
	 * @return string Formated date time string
	 */
	public function getLastChangedFormated()
	{
		return $this->lastChanged->format(self::DATE_TIME_FORMAT);
	}

	/**
	 * Sets the date/time for when the object was last modified on TimeEdit
	 * @param DateTime $lastChanged When it was last changed
	 */
	public function setLastChanged($lastChanged)
	{
		$this->lastChanged = $lastChanged;
	}
	
    public function isIncrementalID()
    {
        return $this->incrementalID;
    }  
    
    public function setIncrementalFlag()
    {
        $this->incrementalID = true;
    }
    
	/**
	 * Compares self with the given object and checks if both of the TableObject
	 * are identical. As some formats doesn't yield all data, this function compares
	 * two objects from two different data sets (eg. ICS and CSV) and checks if they
	 * are the same
	 * @param  TableObject $tableObject Object to compare with
	 * @return Boolean              [description]
	 */
	public function match($tableObject)
	{
		return ($this->timeStart == $tableObject->timeStart && $this->timeEnd == $tableObject->timeEnd
            && self::compareArrays($this->getCourseCodeList(), $tableObject->getCourseCodeList()) // Have all the same courses
            && self::compareArrays($this->getRooms(), $tableObject->getRooms()));                 // And all the same rooms
	}
    
    private function getRooms()
    {
        if (is_string($this->room))
            return array($this->room);
        else
            return $this->room;
    }
    
    private function getCourseCodeList()
    {
        $array = $this->courseCodes;
        if (is_string($array))
        {
            return array($array);
        }
        else if (is_array($array[0]))
        {
            $contents = array();
            foreach ($array as $subarray)
            {
                foreach ($subarray as $key => $value)
                    $contents[] = $key;
            }
            return $contents;
        }
        else
        {
            return $array;
        }
    }

    // Compares two arrays, returns true if equals
    private static function compareArrays($first, $second)
    {
        if (count($first) != count($second))
            return false;
        
        // Two checks are needed as array_diff only checks if there are any items from 
        // the first argument array that is not present in the second argument array
        return (count(array_diff($first, $second)) == 0 && count(array_diff($second, $first)) == 0);
    }
	
	/**
	 * Serializes self for a JSON object
	 * @return Array Valid JSON representation of all the data members in the 
	 *         TableObject to be displayed in the JSON object
	 */
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