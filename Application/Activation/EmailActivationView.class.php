<?php
require_once('IActivationView.interface.php');
require_once('Application/HigifyConfig.class.php');

class EmailActivationView implements IActivationView
{
    /**
     * Genreates the content for the email when a user creates a new account
     * @param string $key The key for activating the account/email
     * @return string The email content
     */
    public static function getEmailContent($key)
    {
        $builder = new StringBuilder();
        $builder->appendLine('Dear Higify user');
        $builder->appendLine();
        $builder->appendLine('A user has been registered with your email address.');
        $builder->appendLine('In order to user your account, please enter the following link in your browser:');
        $builder->appendLine('http://' . HigifyConfig::SITE_DOMAIN . '/activation.php?key=' . $key);
        $builder->appendLine();
        $builder->appendLine('Sincery,');
        $builder->appendLine('The Higify Team');
        
        return $builder->toString();
    }
    
    public static function getEmailSubject()
    {
        return "Activate your Higify account";
    }
}

?>