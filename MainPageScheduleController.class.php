<?php

require_once('Template/IPageController.interface.php');
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('ScheduleObjectElement.class.php');
require_once('Schedule/ScheduleController.class.php');

class MainPageScheduleController implements IPageController
{
    public function onDisplay()
    {
        $userID = SessionController::requestLoggedinID();
        $dailySchedule = ScheduleController::fetchScheduleForTheDay($userID);
        
        $scheduleElement = new ScheduleObjectElement($dailySchedule);
        
        return array('SCHEDULE' => $scheduleElement);
    }
}



?>