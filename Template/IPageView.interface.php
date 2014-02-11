<?php

/**
 * Every view that shall be displayed in a template file implements this interface
 */
interface IPageView
{
    /**
     * Generates an associate array of key => value pairs to be set in the template
     */
    public function generateHTML();
}

?>