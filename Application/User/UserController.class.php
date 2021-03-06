<?php
require_once('UserModel.class.php');

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
        return UserModel::getUser($username, $password);
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
        return UserModel::getUserByID($userID);
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
        if (UserModel::userExists($username))
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
            return true;
        }
       
        return false;
    }
    
    /**
     * Registers a user in the database
     * @param string $username The username
     * @param string $password User's password
     * @param string $email User's email address
     */
    public static function registerUser($username, $password, $email)
    {
        return UserModel::registerUser($username, $password, $email, false);
    }
    
    /**
     * Activates a users email
     * @param  integer $userID The ID of the user to activate
     */
    public static function activateUserEmail($userID)
    {
        UserModel::activateEmail($userID);
    }
    
    /**
     * Requests a profilepicture by userID
     * @param $userID
     * @return The picture 
     */
    public static function requestProfilePicture($userID)
    {
        if ($picture = UserModel::fetchProfilePicture($userID))
            return $picture;
        
        return NULL;
    }
    
    /**
     * Updates a user settings
     * @param  string $oldPassword Their old password
     * @param  string $newPassword Their new password
     * @param  string $newEmail    Their new email
     * @param  mixed  $picture      Picture data
     */
    public static function updateUser($oldPassword, $newPassword, $newEmail, $picture)
    {
        $userID = SessionController::requestLoggedinID();
        
        self::requestPictureSubmit($picture);
        UserModel::newEmail($userID, $newEmail);
        UserModel::newPassword($userID,$oldPassword,$newPassword);
    }

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
        $builder->appendLine('Sincerely,');
        $builder->appendLine('The Higify Team');
        
        return $builder->toString();
    }
    
    /**
     * Updates useremail to $email 
     * 
     * @param $userID id of user
     * @param $email new email adress
     */
    public static function updateEmail($userID, $email)
    {
        UserModel::newEmail($userID,$email);
    }
    
    /**
     * Updates state of the boolean publicTimeSchedule 
     * @param $userID ID of the user
     * @param $bool true: set to public, false: set to private
     */
    public static function updatePublicTime($userID, $bool)
    {
        UserModel::setPublicTimeSchedule($userID, $bool);
    }
    
    /**
     * Requests a password change for a user
     * @param  integer $userID      The ID of the user
     * @param  string $oldpassword  The users old password in plaintext
     * @param  string $newpassword  The users ew password in plaintext
     * @return boolean              True if password was changed, otherwise false (old password doesnt match db values)
     */
    public static function requestPasswordChange($userID,$oldpassword,$newpassword)
    {
        if (UserModel::newPassword($userID,$oldpassword,$newpassword))
            return true;
        return false;
    }
	
	/**
	 * Retrieves an associative array of search results from the data base. 
	 *
	 * @param string searchterm.
	 * @return Associative Array with user ID and Username. 
	 */
	public static function requestSearchResults($searchTerm)
	{
		return UserModel::getSearchResults($searchTerm);
	}
}
  
?>