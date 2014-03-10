<?php
require_once('WebPageElement.class.php');

/**
 * Incapsulates a string that shall be formated as 
 * pure text and shall not be formated by htmltenteties
 */
class EscapedHTMLView extends WebPageElement
{
    /**
     * The string to display
     * @var string
     */
    private $content;
    
    /**
     * Prepares a new EscapedHTMLView
     * @param string $content The text to display
     */
    public function __construct($content)
    {
        $this->content = $content;
    }
    
    /**
     * Generates the output
     */
    public function generateHTML()
    {
        echo strip_tags($this->content, '<br><b><i><ul><li><ol><a><imr><h1><h2><h3><h4><span><div>');
    }
}
?>