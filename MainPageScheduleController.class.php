<?php

require_once('Template/IPageController.interface.php');
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('ScheduleObjectElement.class.php');
require_once('EmptyScheduleView.class.php');
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
		
		$dailySchedule = ScheduleController::fetchScheduleForTheDay($this->profileID);
				
        if (count($dailySchedule) > 0)
			$scheduleElement = new ScheduleObjectElement($dailySchedule);
        else
            $scheduleElement = new EmptyScheduleView();
				
		return array('SCHEDULE' => $scheduleElement);
    }
}



?>