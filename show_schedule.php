<?php
require_once('ScheduleController.class.php');
require_once('SessionController.class.php');

$userID = SessionController::requestLoggedinID();
ScheduleController::fetchTimeTable($userID);
?>