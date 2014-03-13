<?php
require_once('HigifyConfig.class.php');

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
     * Creates (if needed) the PDO object for the database host
     * @return mixed
     */
    public static function getDB()
    {
        if (self::$pdo == NULL)
        {
            self::$pdo = new PDO('mysql:host=' . HigifyConfig::DB_HOST . ';dbname=' . HigifyConfig::DB_NAME . ';charset=utf8',
                                 HigifyConfig::DB_USER, HigifyConfig::DB_PSSW);
            //self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        return self::$pdo;
    }
}

?>