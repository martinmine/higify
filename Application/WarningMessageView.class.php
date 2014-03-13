<?php
include_once('Template/WebPageElement.class.php');
include_once('Template/Template.class.php');

/**
 * A view for displaying a warning message to the user in the login form
 */
class WarningMessageView extends WebPageElement
{
    /**
     * The message to be displayed on the HTML output
     * @var string The message
     */
    private $message;
    
    /**
     * Prepares a new warning message view with a warning message
     * @param string $msg The message to be displayed
     */
    public function __construct($msg)
    {
        $this->message = $msg;
    }
    
    /**
     * Prints the HTML output to the website
     */
    public function generateHTML()
    {
        $tpl = new Template();
        $tpl->appendTemplate('FrontPageWarning');
        $tpl->setValue('MSG', $this->message);
        
        $tpl->display();
    }
}

?>