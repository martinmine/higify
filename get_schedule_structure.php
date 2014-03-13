<?php
require_once('Application/Schedule/ScheduleController.class.php');
require_once('Application/Session/SessionController.class.php');

$userID = SessionController::requestLoggedinID();

$json = ScheduleController::getScheduleWizzardData($userID);

header('Content-Type: application/json');
echo json_encode($json);
?>