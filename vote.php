<?php
require_once('Application/Template/Template.class.php');
require_once('Application/Note/NoteController.class.php');
require_once('Application/Session/SessionController.class.php');

if (isset($_GET['noteid']) && isset($_GET['type']))
{
    $userID = SessionController::requestLoggedinID(true);
    
    if ($userID !== NULL)
    {
        $statusCode = NoteController::registerVote($_GET['noteid'], $userID, $_GET['type']);
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

echo json_encode(array('status' => $status, 'voteresponse' => $statusCode));
?>