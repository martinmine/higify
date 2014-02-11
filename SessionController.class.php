<?php
require_once('SessionModel.class.php');
require_once('SessionView.class.php');
require_once 'UserController.class.php';

class SessionController
{
    public static function aquireSession($disableRedirect = false)
    {
         SessionModel::getLoggedinID();
    }
    
    /**
     * Summary of setLoggedIn
     * @param mixed $loginID 
     */
    public static function setLoggedIn($userID)
    {
        SessionModel::setLoginID($userID);
    }
}


?>