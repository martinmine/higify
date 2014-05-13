<?php
require_once('Application/Template/Template.class.php');
require_once('Application/User/UserController.class.php');
require_once('Application/Session/SessionController.class.php');

if (isset($_GET['user']))
{
    $userID = SessionController::requestLoggedinID(true);
    
    if ($userID !== NULL)
    {
        $statusCode = (UserController::triggerStalkingStatus($_GET['user'], $userID) ? '1' : '0');
        $status = 'OK';
    }
    else
    {
        $statusCode = 0;
        $status = 'NOSESSION';
    }
}
else
{
    $statusCode = 0;
    $status = 'MISSINGPARM';
}

echo json_encode(array('status' => $status, 'stalkstatus' => $statusCode));
?>