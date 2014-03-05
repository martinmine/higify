<?php
require_once('Template/IPageController.interface.php');
require_once('NoteController.class.php');
require_once('UserController.class.php');


class NoteReplyController implements IPageController
{
    private $reply;
    
    public function __construct($reply)
    {
        $this->reply = $reply;
    }
    
    public function onDisplay()
    {   
        foreach (
        $tpl = new Template();
        $tpl->appendTemplate('NoteContainer');
        $tpl->setValue('USERNAME', $reply->getUsername());
        $tpl->setValue('CONTENT', $reply->getContent());
        $tpl->setValue('TIME', $repy->getTime());
      //  $tpl->setValue('NOTEID', $note->getNoteID());
        $tpl->display();
        
    }
}

?>