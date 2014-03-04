<?php
require_once('Template/IPageController.interface.php');
require_once('Template/Template.class.php');
require_once('noteReplyController.class.php');
require_once('NoteController.class.php');
require_once('UserController.class.php');


class NoteRepliesView implements WebPageElement
{
    public function onDisplay()
    {
        $replies = NoteController::requestReplies($_GET['noteID']);
        
        foreach ($replies as $reply)
        {
            $tpl = new Template();
            $tpl->appendTemplate('NoteContainer');
            $tpl->registerController(new NoteReplyController($reply));
            $tpl->display();       
        }
    }
}


?>