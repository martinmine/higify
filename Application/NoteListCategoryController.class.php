<?php
require_once('Template/IPageController.interface.php');
require_once('Note/NoteType.class.php');
require_once('Note/NoteController.class.php');
require_once('User/UserController.class.php');
require_once('Session/SessionController.class.php');
require_once('NoteListView.class.php');

class NoteListCategoryController implements IPageController
{   
    public function onDisplay()
    {        
        return array('NOTES' => new NoteListView(NULL, NoteType::NONE, NULL, $_GET['cat']));
    }
}
?>