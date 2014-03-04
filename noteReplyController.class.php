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
        
    }
}

?>