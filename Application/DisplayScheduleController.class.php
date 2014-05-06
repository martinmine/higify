<?php
require_once('Session/SessionController.class.php');
require_once('Template/IPageController.interface.php');
require_once('Schedule/ScheduleController.class.php');
require_once('User/UserController.class.php');
require_once('ScheduleBody.class.php');

class DisplayScheduleController implements IPageController
{
    /**
    * The week number for this schedule
    * @var integer
    */
    private $weekNumber;
    
    public function __construct($weekNumber)
    {
        $this->weekNumber = $weekNumber;
    }
    
    public function onDisplay()
    {
        $userID = SessionController::requestLoggedinID();
        $schedule = ScheduleController::fetchScheduleForWeek($userID, $this->weekNumber);

        return array('SCHEDULE' => new ScheduleBody($schedule, 8, 19, $this->weekNumber));
    }
}
?>