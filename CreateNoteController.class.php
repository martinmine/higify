<?php
require_once('Template/IPageController.interface.php');
require_once('NoteController.class.php');
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('NoteType.class.php');
require_once('NoteListView.class.php');
require_once('Schedule/ScheduleController.class.php');
require_once('NoteController.class.php');

class CreateNoteController implements IPageController
{   
    public function onDisplay()
    {        
        $vals = array();
        
        if (isset($_GET['parent']))             // If this is a reply
        {
            $vals['ORIGINAL'] = new NoteListView(NULL, NoteType::NONE, $_GET['parent']);
            $vals['OPTIONS'] = NoteController::requestNoteCategory($_GET['parent']); // ------Denne er ikke testet
            
            if (count($_POST) > 0)
            {
                if (strlen($_POST['content'] > 0))
                {
                    NoteController::addNoteReply($_GET['parent'], SessionController::requestLoggedinID(), $_POST['content'], $_POST['category']);
                }     
            }
        }  
            
        $vals['OPTIONS'] = ScheduleController::getCourseElements(SessionController::requestLoggedinID());    

        return $vals;
    }
}

?>
