<?php
require_once('Application/Session/SessionController.class.php');
require_once('Application/User/UserController.class.php');

header("Content-type: image/jpeg");

if (isset($_GET['id']))
{
	$picture = UserController::requestProfilePicture($_GET['id']);
	
	if ($picture === NULL)
		include('static/defaultpicture.png');
	else
		echo $picture;
}
?>