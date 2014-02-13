<?php
/**
 * A parameter used for specifying the time when 
 * getting a time-table from within a specified range
 */
interface ITimeParameter
{
	/**
	 * Formats the time value for the URL specification
	 */
	public function serialize();
}

/**
 * Describes amount of minutes
 */
class Minutes implements ITimeParameter
{
	/**
	 * Amounts of minutes
	 * @var integer
	 */
	private $minutes;
	
	/**
	 * Creates a new Minutes span
	 * @param integer $minutes Amount of minutes
	 */
	public function __construct($minutes)
	{
		$this->minutes = $minutes;
	}
	
	/**
	 * Returns a time point for now
	 * @return Minutes
	 */
	public static function now()
	{
		return new Minutes(0);
	}
	
	/**
	 * Formats the minutes according to the TimeEdit URL specification
	 * @return string URL parameter
	 */
	public function serialize()
	{
		return sprintf('%d.minutes', $this->minutes);
	}
}

/**
 * Describes amount of hours
 */
class Hours implements ITimeParameter
{
	/**
	 * Amount of hours
	 * @var integer
	 */
	private $hours;
	
	/**
	 * Prepares a new Hours time span
	 * @param integer $hours Amount of hours
	 */
	public function __construct($hours)
	{
		$this->hours = $hours;
	}
	
	/**
	 * Serializes the hours to TimeEdit URL
	 * @return string URL parameter
	 */
	public function serialize()
	{
		return sprintf('%d.hours', $this->hours);
	}
}

/**
 * Describes amount of days
 */
class Days implements ITimeParameter
{
	/**
	 * Amount of days
	 * @var integer
	 */
	private $days;
	
	/**
	 * Prepares the Days object
	 * @param integer $days Amount of days
	 */
	public function __construct($days)
	{
		$this->days = $days;
	}
	
	/**
	 * Serializes the amount of days according to the TimeEdit URL specification
	 * @return string URL parameter
	 */
	public function serialize()
	{
		return sprintf('%d.days', $this->days);
	}
}

/**
 * Describes amount of weeks
 */
class Weeks implements ITimeParameter
{
	/**
	 * Amount of weeks
	 * @var integer
	 */
	private $weeks;
	
	/**
	 * Prepares a new Week object
	 * @param integer $weeks Amount of weeks
	 */
	public function __construct($weeks)
	{
		$this->weeks = $weeks;
	}
	
	/**
	 * Serializes the Weeks object according to the TimeEdit URL specs
	 * @return string URL parameter
	 */
	public function serialize()
	{
		return sprintf('%d.weeks', $this->weeks);
	}
}

/**
 * Describes amount of months
 */
class Months implements ITimeParameter
{
	/**
	 * Amount of months
	 * @var integer
	 */
	private $months;
	
	/**
	 * Prepares a new Months object 
	 * @param integer $months Amount of months
	 */
	public function __construct($months)
	{
		$this->months = $months;
	}
	
	/**
	 * Formats the months according to the TimeEdit URL specification
	 * @return string URL parameter
	 */
	public function serialize()
	{
		return sprintf('%d.months', $this->months);
	}
}

/**
 * Describes a given date
 */
class Date implements ITimeParameter
{
	/**
	 * The Date
	 * @var DateTime
	 */
	private $date;
	
	/**
	 * Creates a new Date objects and sets the date
	 * @param DateTime $date The date
	 */
	public function __construct(DateTime $date)
	{
		$this->date = $date;
	}
	
	/**
	 * Serializes the Date for the TimeEdit URL parmaeter
	 * @return string URL parameter
	 */
	public function serialize()
	{
		return $this->date->format('Ymd') . '.x';
	}
}
?>