<?php
	require_once "Application/user/UserController.class.php";
	
	$user = UserController::requestUser($_POST['username'],$_POST['password']);
	$result = array();
		
	$result['ok'] = ($user !== NULL);
	
	if (!$result['ok'])
	{
		$result['msg'] = 'Unknown username / password';
	}
	
	echo json_encode($result);
	
?>