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
        $noteOwner = $note->getUsername();
        
        $tpl = new Template();
        $tpl->appendTemplate('NoteContainer');
        $tpl->setValue('USERNAME', $note->getUsername());
        $tpl->setValue('CONTENT', $note->getContent());
        $tpl->setValue('TIME', $note->getTime());
        $tpl->setValue('NOTEID', $note->getNoteID());
        $option1 = ($username === $noteOwner)? "edit": NULL;
        $option2 = ($username === $noteOwner)? "delete": NULL;
        $tpl->setValue('OPTION1', $option1);
        $tpl->setValue('OPTION2', $option2);
        $tpl->display();
    }
}

?>