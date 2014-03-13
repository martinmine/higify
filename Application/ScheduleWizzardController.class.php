<?php

require_once('Session/SessionController.class.php');
require_once('Template/IPageController.interface.php');
require_once('Schedule/ScheduleController.class.php');
require_once('User/UserController.class.php');

class ScheduleWizzardController implements IPageController
{
    public function onDisplay()
    {
        $vals = array();
        $userID = SessionController::requestLoggedinID();
        
        if (isset($_POST['scheduleData']))
        {
            UserController::updatePublicTime($userID, (isset($_POST['schedulePublic']) && $_POST['schedulePublic'] == 'private' ? false : true));
            ScheduleController::saveSchedule($_POST['scheduleData'], $userID);
            header('Location: mainpage.php');
            exit;
        }
        
        $user = UserController::requestUserByID($userID);
        
        $vals['IS_PUBLIC'] = $user->hasPublicTimeTable();
        $vals['FIRST_TIME'] = isset($_GET['firsttime']);
        
        return $vals;
    }
}
?>