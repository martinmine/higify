<?php
require_once('Application/Session/SessionController.class.php');

SessionController::logout();

header('Location: login.php');
?>