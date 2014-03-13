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
    
    /**
     * Salt used for salting the users password
     */
    const SALT = 'abcfds11jhG';
    
     /**
     * Site key used for initializing the users password
     */
    const SITEKEY = 'n8eyr2nsdasd23119bh91b';
    
     /**
     * 
     */
    const MAIL_HOST = 'mail.dongsecurity.com';                // Specify main and backup server
    
    /**
     * Use AMPTH authentication for mail
     */
    const MAIL_SMTP_AUTH = true;
    
    /**
     * The username for the mail account
     */
    const MAIL_USERNAME = 'activation@obbahhost.com';
    
    /**
     * Password for mail account
     */
    const MAIL_PASSWORD = 'Vtft32XRp8FVZQGvETu4vpmM';
    
    /**
     * SMTP port
     */
    const MAIL_PORT = 94;
    
    /**
     * Who the email is from
     */
    const MAIL_TITLE_FROM = 'activation@obbahhost.com';
    
    /**
     * And the title on the from name
     */
    const MAIL_TITLE_FROM_NAME = 'The Higify Team';

    /**
     * The salt used to create new tokens
     */
    const COOKIE_SALT = 'xEvMHDfVbM6SYZN7EsBQ6NUFpT7PyGnYfSfbWFeTETb7vJ4Y2zFtBmxd6uysYpEFMvp7ZFqdPbJHPbbjFEhUPQb524ZMRpaJcy9qCS5h8aPgad9JZ4ArcqXy';
    
    /**
     * Random key used for initializing the hash function
     */
    const HASH_INIT = 'hQVJ5TaKt7QTaScYrvFsaPPJKEpB56X6y9QzEYKcNvST8DpYDymrx7JWfGDUBHSpBugzw3L2Ce9MuAeGe6KNw2MCvMsjCnmEwtuHDgWyXHV2HVW7K3GQgT7g'; 
}

?>