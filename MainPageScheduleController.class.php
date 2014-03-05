<?php

require_once('Template/IPageController.interface.php');
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('ScheduleObjectElement.class.php');
require_once('Schedule/ScheduleController.class.php');

class MainPageScheduleController implements IPageController
{
	private $profileID;
	
	public function __construct($profileID)
	{
		$this->profileID = $profileID;
	}
	
	public function onDisplay()
	{
		$userID  = SessionController::requestLoggedinID();
		$profile = UserController::requestUserByID($this->profileID);
		
		if ($userID !== NULL  &&  $profile !== NULL)
		{
			if ($userID === $this->profileID  ||  $profile->hasPublicTimeTable())
			{
				$dailySchedule = ScheduleController::fetchScheduleForTheDay($this->profileID);
				
				$scheduleElement = new ScheduleObjectElement($dailySchedule);
				
				return array('SCHEDULE' => $scheduleElement);
			}
		}
		return array('SCHEDULE' => '');
    }
}



?>