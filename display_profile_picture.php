<?php
require_once('SessionController.class.php');
require_once('UserController.class.php');

header("Content-type: image/jpeg");

if (isset($_GET['id']))
{
    $picture = NULL;
	$picture = UserController::requestProfilePicture($_GET['id']);
	
	if ($picture === NULL)
		include('static/defaultpicture.png');
	else
		echo $picture;
}
?>