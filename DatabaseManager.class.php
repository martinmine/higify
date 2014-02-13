<?php

/**
 * Manages and configures the PDO object used for database interaction
 */
class DatabaseManager
{
    /**
     * The PDO instance
     * @var PDO
     */
    private static $pdo = NULL;
    
    /**
     * The host-name used for connecting to the databse. Can also be IP-address.
     */
    const DB_HOST = 'phpmyadmin.obbahhost.com';
    
    /**
     * Username used when connecting to the database
     */
    const DB_NAME = 'higify';
    
    /**
     * Name of the database
     */
    const DB_USER = 'higifydev';
    
    /**
     * Super secret database password
     */
    const DB_PSSW = '6DLqsad9rbmFjcL7abvYDnzy';
    
    /**
     * Creates (if needed) the PDO object for the database host
     * @return mixed
     */
    public static function getDB()
    {
        if (self::$pdo == NULL)
        {
            self::$pdo = new PDO('mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=utf8',
                                 self::DB_USER, self::DB_PSSW);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        return self::$pdo;
    }
}

?>