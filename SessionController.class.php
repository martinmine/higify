<?php
require_once('SessionModel.class.php');
require_once('SessionView.class.php');
require_once('UserController.class.php');
require_once('user/UserModel.class.php');

/**
 * Manages the users session data and wether a user is logged in or not
 */
class SessionController
{
    /**
     * Gets the User instance of a given user. If no user was found, it will be redirected.
     * @param boolean $disableRedirect If set to true, user won't be redirected when a user is signed in.
     *                                 Otherwise if a user is not found, user will be redirected and script will stop.
     * @return The User object, otherwise NULL if no user is found (disableRedirect must be set)
     */
    public static function acquireSession($disableRedirect = false)
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
             return UserController::getUserByID($userID);                // User in session! Fetch userdata from db
         }
    }
    
    /**
     * Sets the logged in user ID for a session and redirects the user
     * @param integer $loginID The users ID
     */
    public static function setLoggedIn($userID, $rememberPassword = false)
    {
        SessionModel::setLoginID($userID);
        header('Location: loggedin.php');
    }
}


?>