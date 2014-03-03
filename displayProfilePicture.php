<?php
require_once('SessionController.class.php');
require_once('UserController.class.php');
	
	$profileID = (isset($_GET['id']))? $_GET['id']: NULL;
	
	if ($profileID !== NULL)
	{
		
		//$userID = SessionController::requestLoggedinID();
		$picture = UserController::requestProfilePicture($profileID);
		
		header("Content-type: image/jpeg");
		if ($picture == NULL)
		{
			include('static/defaultpicture.png');
		}
		else
			echo $picture;
			
	}
	else
	{
		header('Location: mainpage.php');
	}
?>