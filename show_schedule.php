<?php
require_once('Schedule/ScheduleController.class.php');
require_once('Schedule/SessionController.class.php');

$userID = SessionController::requestLoggedinID();
ScheduleController::fetchTimeTable($userID);
?>