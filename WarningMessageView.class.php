<?php
include_once('Template/WebPageElement.class.php');
include_once('Template/Template.class.php');

class WarningMessageView extends WebPageElement
{
    private $message;
    
    public function __construct($msg)
    {
        $this->message = $msg;
    }
    
    public function generateHTML()
    {
        $tpl = new Template();
        $tpl->appendTemplate('LoginWarning');
        $tpl->setValue('MSG', $this->message);
        
        $tpl->display();
    }
}

?>