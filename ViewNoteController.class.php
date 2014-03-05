<?php
require_once('Template/IPageController.interface.php');
require_once('NoteController.class.php');
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('NoteType.class.php');
require_once('NoteListView.class.php');

class ViewNoteController implements IPageController
{   
    public function onDisplay()
    {        
        $vals = array();
        
        $vals['ORIGINAL'] = new NoteListView(NULL, NoteType::NONE, $_GET['id']);
        $vals['NOTES'] = new NoteListView(NULL, NoteType::REPLY, $_GET['id']);
        
        return $vals;
    }
}
?>