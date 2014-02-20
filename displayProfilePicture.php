<?php
function displayProfilePicture($userID)
{
	require_once('UserModel.class.php');
	$picture = UserModel::fetchProfilePicture($userID);

	header("Content-type: image/jpeg");
	if ($picture === NULL)
	{
		include ('/static/defaultpicture.png');
	}
	else
		echo $picture;
}
?>