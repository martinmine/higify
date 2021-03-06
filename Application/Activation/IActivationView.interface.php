<?php
interface IActivationView
{
    /**
     * Generates the email content
     * @param string $key The activation key in the URL in the email content
     */
    public static function getEmailContent($key);
    
    /**
     * Gets the subject of the email to send
     */
    public static function getEmailSubject();
}
?>