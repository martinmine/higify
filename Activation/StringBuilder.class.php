<?php
/**
 * String builder meant for email content.
 */
class StringBuilder
{
    /**
     * What is in the string builder so far
     * @var string
     */
    private $content;
    
    /**
     * Appends a single string to the string builder
     * @param string $txt String to append
     */
    public function append($txt)
    {
        $this->content .= $txt;
    }
    
    /**
     * Appends one line to the string builder with a newline+br-tag
     * @param string $txt 
     */
    public function appendLine($txt = '')
    {
        $this->content .= $txt . "\n<br/>";
    }
    
    /**
     * Returns the current content of the string builder
     * @return string The content
     */
    public function toString()
    {
        return $this->content;
    }
}
?>