<?php
require_once('SessionController.class.php');

SessionController::logout();

header('Location: login.php');
?>