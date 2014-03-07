<?php

class HigifyConfig
{
    /**
     * The host-name used for connecting to the databse. Can also be IP-address.
     */
    const DB_HOST = '128.39.41.101';
    
    /**
     * Username used when connecting to the database
     */
    const DB_NAME = 's121050';
    
    /**
     * Name of the database
     */
    const DB_USER = 's121050';
    
    /**
     * Super secret database password
     */
    const DB_PSSW = 'MfvZNb2f';
    
    /**
     * Private recaptcha API key
     */
    const RECAPTCHA_PRIVATE_KEY = '6Lfis-4SAAAAANi6ne8PD0-i9U9z8X8PvKnGhJiG';
    
    /**
     * Public recaptcha API key
     */
    const RECAPTCHA_PUBLIC_KEY = '6Lfis-4SAAAAAKnGTAWkuCwryfiHKK0OlNM0MjIe';
    

    public static $BAD_PASSWORDS = array ('123456', 'password' , '12345678', 'qwerty', 'abc123', '123456789', '111111', 
                                    '1234567', 'iloveyou', 'adobe123', '123123', 'admin', '1234567890', 'letmein', 
                                    'photoshop', '1234', 'monkey', 'shadow', 'sunshine', '12345', 'password1', 
                                    'princess', 'azerty', 'trustno1', 'qwerty123', 'asdfg', 'fronter', 'student'); 

    /**
     * The domain used in the website
     */
    const SITE_DOMAIN = 'localhost';
}

?>