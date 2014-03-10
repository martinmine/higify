<?php
require_once('SessionController.class.php');
require_once('Template/IPageController.interface.php');
require_once('Schedule/ScheduleController.class.php');
require_once('UserController.class.php');
require_once('ScheduleBody.class.php');

class DisplayScheduleController implements IPageController
{
    public function onDisplay()
    {
        $userID = SessionController::requestLoggedinID();
        $schedule = ScheduleController::fetchScheduleForWeek($userID);

        return array('SCHEDULE' => new ScheduleBody($schedule, 8, 19));
    }
}
?>