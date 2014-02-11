<?php
include_once('Template/IPageView.interface.php');
include_once('Template/Template.class.php');

class ErrorMessageView extends IPageView
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