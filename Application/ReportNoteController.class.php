<?php
require_once('User/UserController.class.php');
require_once('Session/SessionController.class.php');
require_once('Template/IPageController.interface.php');
require_once('Note/NoteController.class.php');

class ReportNoteController implements IPageController
{
	public function onDisplay()
	{	
        $userID = SessionController::requestLoggedinID();
        
        if (isset($_GET['id'])) // A note is reported by a user
        {
            NoteController::reportNote($_GET['id'], $userID);
        }
        else if (isset($_GET['noteID']) && isset($_GET['userID'])) // An admin is ignoring a reported note
        {
            $user = UserController::requestUserByID($userID);
            if ($user->getRank() > 0)
                NoteController::ignoreReportedNote($_GET['noteID'], $_GET['userID']);
        }
        
        return array();
    }
}
?>