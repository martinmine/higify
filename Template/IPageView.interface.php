<?php

/**
 * Every view that shall be displayed in a template file implements this interface
 */
abstract class IPageView
{
    /**
     * When called, would print the contents of the view and the content would be appended to the template
     */
    public function __toString()
    {
        $this->generateHTML();
        return '';
    }
    
    public abstract function generateHTML();
}

?>