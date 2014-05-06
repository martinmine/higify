<?php
require_once('Template/IPageController.interface.php');
require_once('Note/NoteController.class.php');
require_once('Note/NoteType.class.php');
require_once('User/UserController.class.php');
require_once('Note/VoteStatus.class.php');
require_once('Session/SessionController.class.php');
require_once('NoteListView.class.php');

class ViewNoteController implements IPageController
{   
    public function onDisplay()
    {        
        $vals = array();
        
        $vals['ORIGINAL'] = new NoteListView(NULL, NoteType::NONE, $_GET['nid']);
        $vals['NOTES'] = new NoteListView(NULL, NoteType::REPLY, $_GET['nid']);
        
        return $vals;
    }
}
?>