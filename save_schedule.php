<?php
require_once('ScheduleController.class.php');
require_once('SessionController.class.php');

$userID = SessionController::requestLoggedinID();
if (isset($_POST['scheduleData']))
{
    ScheduleController::saveSchedule($_POST['scheduleData'], $userID);
}
else
{
    echo "No post data was submitted";
}
?>