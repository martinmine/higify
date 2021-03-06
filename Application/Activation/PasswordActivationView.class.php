<?php
require_once('IActivationView.interface.php');
require_once('Application/HigifyConfig.class.php');
require_once('StringBuilder.class.php');

class PasswordActivationView implements IActivationView
{
    /**
     * Creates the email content for a forgotten password case
     * @param string $key The activation key
     * @return string The email content
     */
    public static function getEmailContent($key)
    {
        $builder = new StringBuilder();
        
        $builder->appendLine('Dear Higify User,');
        $builder->appendLine();
        $builder->appendLine('Someone issued a new password on your account from the IP address ' . $_SERVER['REMOTE_ADDR'] . '.');
        $builder->appendLine('We will let you createa a new password if you enter this link in your browser: ');
        $builder->appendLine('http://' . HigifyConfig::SITE_DOMAIN . '/activation.php?key=' . $key);
        $builder->appendLine();
        $builder->appendLine('Sincery,');
        $builder->appendLine('The Higify Team');
        
        return $builder->toString();
    }
    
    /**
     * Get the subject of an email when it is a lost password email
     * @return string Email subject
     */
    public static function getEmailSubject()
    {
        return "Lost password on Higify";
    }
}

?>