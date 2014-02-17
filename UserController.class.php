<?php
require_once('UserModel.class.php');
require_once('SessionController.class.php');

class UserController
{
    /**
     * Summary of requestUser
     * @param $username     Username used for login
     * @param $password     Password used for login
     * @return userobject if exists, else NULL
     */
    public static function requestUser($username, $password)  
    {
        $user = UserModel::getUser($username, $password);
        if ($user !== NULL)
         {
             return $user;
         }
         
         return NULL;
    }
    
    /**
     * Summary of requestUserByID
     * 
     * Looks up a userID, return user object.
     * 
     * @param $userID 
     * @return userobject if exists, else NULL
     */
    public static function requestUserByID($userID)
    {
        $user = UserModel::getUserByID($userID);
        if ($user !== NULL)
        {
            return $user;
        }
        
        return NULL;
    }
    
    
    /**
     * Takes in a picture e.g  $_FILES['picture'] and tests for
     * availability. Requests picturesubmit from usermodel. 
     * 
     * @param $picture
     */
    public static function requestPictureSubmit($userID,$picture)
    {
        if (is_uploaded_file($picture))
        {
           // $userID = SessionController::requestLoggedinID();
            UserModel::submitPicture($userID, $picture);
        }
    }
}
?>