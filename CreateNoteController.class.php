<?php
require_once('Template/IPageController.interface.php');
require_once('NoteController.class.php');
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('NoteType.class.php');
require_once('NoteListView.class.php');
require_once('Schedule/ScheduleController.class.php');

class CreateNoteController implements IPageController
{   
    public function onDisplay()
    {        
        $vals = array();
        
        if (isset($_GET['id']))
        {
            $vals['ORIGINAL'] = new NoteListView(NULL, NoteType::NONE, $_GET['id']);
        }
        $vals['CATEGORIES'] = 'wwwtec';
           
        $vals['OPTIONS'] = ScheduleController::getCourseElements(SessionController::getLoggedinID());
        
        return $vals;
    }
}
?>