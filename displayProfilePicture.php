<?php
	require_once('UserModel.class.php');
	$picture = UserModel::fetchProfilePicture($_GET['id']);

	header("Content-type: image/jpeg");
	if ($picture === NULL)
	{
		include ('/static/defaultpicture.png');
	}
	else
		echo $picture;
?>