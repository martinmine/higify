<?php

class HigifyConfig
{
    /**
     * The host-name used for connecting to the databse. Can also be IP-address.
     */
    const DB_HOST = '';
    
    /**
     * Username used when connecting to the database
     */
    const DB_NAME = '';
    
    /**
     * Name of the database
     */
    const DB_USER = '';
    
    /**
     * Super secret database password
     */
    const DB_PSSW = '';
    
    /**
     * Private recaptcha API key
     */
    const RECAPTCHA_PRIVATE_KEY = '';
    
    /**
     * Public recaptcha API key
     */
    const RECAPTCHA_PUBLIC_KEY = '';
    

    public static $BAD_PASSWORDS = array ('123456', 'password' , '12345678', 'qwerty', 'abc123', '123456789', '111111', 
                                    '1234567', 'iloveyou', 'adobe123', '123123', 'admin', '1234567890', 'letmein', 
                                    'photoshop', '1234', 'monkey', 'shadow', 'sunshine', '12345', 'password1', 
                                    'princess', 'azerty', 'trustno1', 'qwerty123', 'asdfg', 'fronter', 'student'); 

    /**
     * The domain used in the website
     */
    const SITE_DOMAIN = 'localhost';
    
    /**
     * Salt used for salting the users password
     */
    const SALT = '';
    
     /**
     * Site key used for initializing the users password
     */
    const SITEKEY = '';
    
     /**
     * 
     */
    const MAIL_HOST = '';                // Specify main and backup server
    
    /**
     * Use AMPTH authentication for mail
     */
    const MAIL_SMTP_AUTH = true;
    
    /**
     * The username for the mail account
     */
    const MAIL_USERNAME = '';
    
    /**
     * Password for mail account
     */
    const MAIL_PASSWORD = '';
    
    /**
     * SMTP port
     */
    const MAIL_PORT = 25;
    
    /**
     * Who the email is from
     */
    const MAIL_TITLE_FROM = '';
    
    /**
     * And the title on the from name
     */
    const MAIL_TITLE_FROM_NAME = '';

    /**
     * The salt used to create new tokens
     */
    const COOKIE_SALT = '';
    
    /**
     * Random key used for initializing the hash function
     */
    const HASH_INIT = ''; 
}

?>
