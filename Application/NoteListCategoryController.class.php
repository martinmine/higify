<?php
require_once('Template/IPageController.interface.php');
require_once('Note/NoteType.class.php');
require_once('NoteController.class.php');
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('NoteListView.class.php');

class NoteListCategoryController implements IPageController
{   
    public function onDisplay()
    {        
        return array('NOTES' => new NoteListView(NULL, NoteType::NONE, NULL, $_GET['cat']));
    }
}
?>