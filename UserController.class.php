<?php
require_once('user/UserModel.class.php');
require_once('SessionController.class.php');

class UserController
{
    public static function loginUser($username)
    {
         if($userID = UserModel::getUserID($username))
         {
             SessionController::setLoggedIn($userID);
         }
    }
}
?>