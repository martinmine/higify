<?php
include_once('Template/WebPageElement.class.php');
include_once('Template/Template.class.php');

/**
 * A view for displaying an error for the user in the login form
 */
class ErrorMessageView extends WebPageElement
{
    /**
     * The error message to be shown to the user
     * @var string the error message
     */
    private $message;
    
    /**
     * Prepares an ErrorMessage box to be displayed as HTML
     * @param string $msg The message to be shown
     */
    public function __construct($msg)
    {
        $this->message = $msg;
    }
    
    /**
     * Prints the HTML code for an error message
     */
    public function generateHTML()
    {
        $tpl = new Template();
        $tpl->appendTemplate('FrontPageError');
        $tpl->setValue('MSG', $this->message);
        
        $tpl->display();
    }
}

?>