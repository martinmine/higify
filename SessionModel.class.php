<?php
require('DatabaseManager.class.php');

class SessionModel
{
    /**
     * The salt used to create new tokens
     */
    const COOKIE_SALT = 'xEvMHDfVbM6SYZN7EsBQ6NUFpT7PyGnYfSfbWFeTETb7vJ4Y2zFtBmxd6uysYpEFMvp7ZFqdPbJHPbbjFEhUPQb524ZMRpaJcy9qCS5h8aPgad9JZ4ArcqXy';
    
    /**
     * Random key used for initializing the hash function
     */
    const HASH_INIT = 'hQVJ5TaKt7QTaScYrvFsaPPJKEpB56X6y9QzEYKcNvST8DpYDymrx7JWfGDUBHSpBugzw3L2Ce9MuAeGe6KNw2MCvMsjCnmEwtuHDgWyXHV2HVW7K3GQgT7g';
    
    /**
     * The domain used in the website
     */
    const SITE_DOMAIN = 'localhost';
    
    
    private static $sessionStarted = false;
    /**
     * Creates a new token from the key
     * @param string Can be old token or the user's password hash
     * @return string A new token
     */
    private static function createToken($key)
    {
        return hash_hmac('sha512', $key . self::COOKIE_SALT, self::HASH_INIT);
    }
    
    /**
     * Returns the ID of the signed in user. This checks both session and cookie (remember me)
     * @return mixed Returns false if no ID was found, otherwise the ID of the signed in user
     */
    public static function getLoggedinID()
    {
        self::prepareSession();
        
        if (isset($_SESSION['LOGIN_ID']))
        {
            return $_SESSION['LOGIN_ID'];
        }
        else if (isset($_COOKIE['USR_ID']) && isset($_COOKIE['TOKEN']))
        {
            $userID = intval($_COOKIE['USR_ID']);
            $token = $_COOKIE['TOKEN'];
            
            $pdo = DatabaseManager::getDB();
            $query = $pdo->prepare('SELECT userID, chainKey FROM UserToken WHERE userID = :userID AND chainKey = :token');
            $query->bindParam('userID', $userID);
            $query->bindParam('token', $token);
            $query->execute();
            
            $rowData = $query->fetch(PDO::FETCH_ASSOC);
            
            if ($rowData)   // Match, update db and cookie
            {
                $newToken = createToken($rowData['chainKey']);
                $query = $pdo->prepare('UPDATE UserToken SET chainKey = :newChainKey WHERE userID = :userID AND chainkey = :oldChainKey');
                $query->bindParam('userID', $userID);
                $query->bindParam(':newChainKey', $newToken);
                $query->bindParam(':oldChainKey', $rowData['chainKey']);
                $query->execute();
                
                setcookie('TOKEN', $newToken, 60*60*24*30, '/', self::SITE_DOMAIN);
                
                return $userID;
            }
            else    // Invalid key used, unset the cookie
            {
                setcookie('TOKEN', NULL, -1, '/', self::SITE_DOMAIN);
                return false;
            }
            
            return $_COOKIE['LOGIN_ID'];   
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Sets the login ID for the assigned session
     * @param integer $userID           The users ID
     * @param boolean $rememberPassword Is set to true if the password shall be remembered, will then use cookies
     */
    public static function setLoginID($userID, $rememberPassword = false)
    {
        self::prepareSession();
        $_SESSION['LOGIN_ID'] = $userID;
        
        if ($rememberPassword)
        {
            $token = self::createToken($userID . rand());
            
            $pdo = DatabaseManager::getDB();
            $query = $pdo->prepare('INSERT INTO UserToken (userID, chainKey) VALUES (:userID, :chainKey)');
            $query->bindParam('userID', $userID);
            $query->bindParam(':chainKey', $token);
            $query->execute();
            
            setcookie('USR_ID', $userID, 60*60*24*30, '/', self::SITE_DOMAIN);
            setcookie('TOKEN', $newToken, 60*60*24*30, '/', self::SITE_DOMAIN);
        }
    }
    
    private static function prepareSession()
    {
        if (!self::$sessionStarted)
        {
            session_start();
            self::$sessionStarted = true;
        }   
    }
}
?>