<?php
require_once('SessionController.class.php');
require_once('UserController.class.php');

    $userID = SessionController::requestLoggedinID();
	$picture = UserController::requestProfilePicture($userID);
    
	header("Content-type: image/jpeg");
	if ($picture === NULL)
	{
		include ('/static/defaultpicture.png');
	}
	else
		echo $picture;
?>