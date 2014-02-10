<?php
require_once('ActivationController.class.php');
require_once('ActivationType.class.php');
require_once('ActivationModel.class.php');

$key = ActivationController::generateActivationKey(1, 'martin_mine@hotmail.com', ActivationType::EMAIL);
echo $key;

?>