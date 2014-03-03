<?php
require_once('Template/IPageController.interface.php');
require_once('Schedule/ScheduleController.class.php');
require_once('SessionController.class.php');

class WizzardController implements IPageController
{
    public function onDisplay()
    {
        $userID = SessionController::requestLoggedinID();
        
        if (!empty($_POST['scheduleData']))
        {
            
            ScheduleController::saveSchedule($_POST['scheduleData'], $userID);
            echo $_POST['scheduleData'];
            die();
            header('Location: mainpage.php');
        }
        
        return array();
    }
}

?>