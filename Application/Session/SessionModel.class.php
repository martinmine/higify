<?php
require_once('Application/DatabaseManager.class.php');
require_once('Application/HigifyConfig.class.php');

class SessionModel
{

    /**
     * Flag for if the session is started or not
     * @var boolean
     */
    private static $sessionStarted = false;
    
    /**
     * Creates a new token from the key
     * @param string Can be old token or the user's password hash
     * @return string A new token
     */
    private static function createToken($key)
    {
        return substr(hash_hmac('sha512', $key . HigifyConfig::COOKIE_SALT, HigifyConfig::HASH_INIT), 0, 30);
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
                /*$newToken = self::createToken($rowData['chainKey']);
                $query = $pdo->prepare('UPDATE UserToken SET chainKey = :newChainKey WHERE userID = :userID AND chainkey = :oldChainKey');
                $query->bindParam('userID', $userID);
                $query->bindParam(':newChainKey', $newToken);
                $query->bindParam(':oldChainKey', $rowData['chainKey']);
                $query->execute();
                
                setcookie('TOKEN', $newToken, time() + 60*60*24*30, '/', HigifyConfig::SITE_DOMAIN);*/
                return $userID;
            }
            else    // Invalid key used, unset the cookie
            {
                setcookie('TOKEN', NULL, -1);
                return false;
            }
        }
        
        return false;
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
            $pdo->exec('DELETE FROM UserToken WHERE userID = ' . $userID);
            $query = $pdo->prepare('INSERT INTO UserToken (userID, chainKey) VALUES (:userID, :chainKey)');
            $query->bindParam('userID', $userID);
            $query->bindParam(':chainKey', $token);
            $query->execute();
            
            setcookie('USR_ID', $userID, time() + 60*60*24*30); 
            setcookie('TOKEN', $token, time() + 60*60*24*30); 
        }
    }
    
    /**
     * Calls the session_start, reads the session cookie and loads all the data for the super global session array
     */
    private static function prepareSession()
    {
        if (!self::$sessionStarted)
        {
            session_start();
            self::$sessionStarted = true;
        }   
    }
    
    /**
     * Unsets the logged in session ID and clears the cookies if they are set
     */
    public static function destroySession()
    {
        self::prepareSession();
        unset($_SESSION['LOGIN_ID']);
        
        if (isset($_COOKIE['USR_ID']) && isset($_COOKIE['TOKEN']))
        {
            setcookie('USR_ID', NULL, -1); 
            setcookie('TOKEN', NULL, -1); 
        }
    }
}
?>