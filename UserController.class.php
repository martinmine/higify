<?php
require_once('UserModel.class.php');
require_once('SessionController.class.php');
require_once('Activation/ActivationController.class.php');
require_once('Activation/ActivationType.class.php');
require_once('Activation/StringBuilder.class.php');

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
     * Looks up user using email adress, returns user object
     * @param $email
     * @return
     */
    public static function requestUserByEmail($email)
    {
        return UserModel::getUserByEmail($email);
    }
    
    /**
     * Sends a query to database asking if a user with 
     * parameter username exists
     * 
     * @param $username
     * @return true if user exists in database, else false.
     */
    public static function userExists($username)
    {
        if(UserModel::userExists($username))
            return true;
        
        return false;
    }
    
    
    /**
     * Takes in a picture e.g  $_FILES['picture'] and tests for
     * availability. Requests picturesubmit from usermodel. 
     * 
     * @param $picture
     */
    public static function requestPictureSubmit($picture)
    {
        if (is_uploaded_file($picture))
        {
            $userID = SessionController::requestLoggedinID();
            UserModel::submitPicture($userID, $picture);
        }
       
        return NULL;
    }
    
    /**
     * Registers a user in the database
     * @param string $username The username
     * @param string $password User's password
     * @param string $email User's email address
     */
    public static function registerUser($username, $password, $email)
    {
        $userID = UserModel::registerUser($username, $password, $email, false, false);
        ActivationController::generateActivationKey($userID, $email, ActivationType::EMAIL);
    }
    
    public static function activateUserEmail($userID)
    {
        UserModel::activateEmail($userID);
    }
    
    /**
     * Requests a profilepicture by userID
     * @param $userID
     * @return
     */
    public static function requestProfilePicture($userID)
    {
        if($picture = UserModel::fetchProfilePicture($userID))
        {
            return $picture;
        }
        
        return false;
    }
    
<<<<<<< HEAD
    public static function updateUser($oldPassword, $newPassword, $newEmail, $picture)
    {
        $userID = SessionController::requestLoggedinID();
        
        self::requestPictureSubmit($picture);
        UserModel::newEmail($userID, $newEmail);
        UserModel::newPassword($userID,$oldPassword,$newPassword);
=======
    /**
     * Resets the users password and returns the content of the email that shall be sent to the user
     * @param User $user The user
     * @param string $newPassword The new password
     * @return string Email content with the username and the password
     */
    public static function notifyPasswordChange($user, $newPassword)
    {
        UserModel::setPassword($user->getUserID(), $newPassword);
        
        $builder = new StringBuilder();
        
        $builder->appendLine('Greeting Higify User!');
        $builder->appendLine();
        $builder->appendLine('Your password has been changed. You can now sign in with the following username and password:');
        $builder->appendLine('Username: ' . $user->getUsername());
        $builder->appendLine('Password: ' . $newPassword);
        $builder->appendLine();
        $builder->appendLine('Sincery,');
        $builder->appendLine('The Higify Team');
        
        return $builder->toString();
>>>>>>> bdf6e01290d80e4efa71f166355486b18feb53e6
    }
}
  
?>