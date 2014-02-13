<?php
include_once('Template/WebPageElement.class.php');
include_once('Template/Template.class.php');

class ErrorMessageView extends WebPageElement
{
    private $message;
    
    public function __construct($msg)
    {
        $this->message = $msg;
    }
    
    public function generateHTML()
    {
        $tpl = new Template();
        $tpl->appendTemplate('LoginError');
        $tpl->setValue('MSG', $this->message);
        
        $tpl->display();
    }
}

?>