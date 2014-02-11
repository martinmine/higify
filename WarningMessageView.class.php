<?php
include_once('Template/IPageView.interface.php');
include_once('Template/Template.class.php');

class WarningMessageView extends IPageView
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