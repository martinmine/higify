<?php
require_once('SessionModel.class.php');

/**
 * Manages the users session data and wether a user is logged in or not
 */
class SessionController
{
    /**
     * Gets the ID of the logged in user
     * @return userID of logged in user
     */
    public static function requestLoggedinID($disableRedirect = false)
    {
        $userID = SessionModel::getLoggedinID();                        // Fetches logged in user
        
        if ($userID === false)                                          // If there is no logged in user
        {
            if (!$disableRedirect)                                      // Redirect to login page
                header('Location: index.php');             
            else
                return NULL;                                            // If disable redirect is false return NULL
        }
        else
        {
            return $userID;
        }
    }
    
    /**
     * Sets the logged in user ID for a session and redirects the user
     * @param integer $loginID The users ID
     */
    public static function setLoggedIn($userID, $rememberPassword = false)
    {
        SessionModel::setLoginID($userID, $rememberPassword);
        header('Location: mainpage.php');
    }
    
    /**
     * Logs the user out and invalidates the session data
     */
    public static function logout()
    {
        SessionModel::destroySession();
    }
}


?>