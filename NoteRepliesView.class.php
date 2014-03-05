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
        
        $tpl = new Template();
        $tpl->appendTemplate('MainPageHeader');
        $tpl->setValue('PAGE_TITLE', 'Your Higify');
        $tpl->setValue('CSS', array('mainpage', 'search', 'menu'));
        $tpl->appendTemplate('Replies');
        $tpl->registerController(new NoteReplyController($reply));
      
        $tpl->display();
    }
}


?>