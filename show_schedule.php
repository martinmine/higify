<?php
require_once('Schedule/ScheduleController.class.php');
require_once('SessionController.class.php');
require_once('ScheduleBody.class.php');

$userID = SessionController::requestLoggedinID();
$schedule = ScheduleController::fetchScheduleForWeek($userID);

$body = new ScheduleBody($schedule, 8, 17);
$body->generateHTML(); // Just for testing untill we get a template and break down things more

?>