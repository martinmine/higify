<?php
require_once ('DatabaseManager.class.php');
require_once ('User.class.php');

class UserModel
{
    const SALT = 'abcfds11jhG';
    
    const SITEKEY = 'verycodedwowsutchsecret';
    
    /**
     * Sends a query to the database to see if the
     * value of $username has a match.
     * @param $username
     * @return true,false
     */
    public static function userExists($username)        // Boolean, checks if username is listed in database
    {                                                   // SQL query
        $query = "SELECT username               
                  FROM user
                  WHERE username = :username";
        $db = DatabaseManager::getDB();
        $stmt = $db->prepare($query);                   // Preparing database
        $stmt->bindparam(':username', $username);   
        $stmt->execute();                               // executing query
        $result = $stmt->fetch(PDO::FETCH_ASSOC);       // fetching result 
        
       if(isset($result['username']))                   // checking if anything was returned to $result
           return true;                                 // User exists in database
       else
            return false;                               // User does not exist in database
    }
    
    
    /**
     * Creates and returns a User object
     * if the username exists in the database.
     * 
     * @param $username, $password
     * @return User A User from the database with the username and password 
     */
    public static function getUser($username, $password)       
    {
        if (UserModel::userExists($username))
        {                                                                                           // SQL query
            $query = "SELECT userID, username, email, emailActivated                                   
                      FROM user
                      WHERE username = :username AND password = :password";
            
            $hashedPassword = hash_hmac('sha512', $password . UserModel::SALT, UserModel::SITEKEY); // Hashing password
           
            $db = DatabaseManager::getDB();
            $stmt = $db->prepare($query);                                                           // Preparing query
            $stmt->bindparam(':username', $username);                                   
            $stmt->bindparam(':password', $hashedPassword);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);                                            // Fetching associated
            
            if ($result)
            {
                $user = new User($result['userID'], $result['username'], 
                                 $result['email'], $result['emailActivated']);              // Creating new user object
                return $user;                                                               // Returns the user object
            }
            else
            {
                return NULL;                                                             // Something went wrong!
            }
        }   
        else
        {
            return NULL;                                                                 // User does not exist
        }
    }
    
    /**
     * Summary of getUserByID
     * 
     * Looks up userID and returns the user as a user object
     * 
     * @param $userID
     * @return User from database 
     */
    public static function getUserByID($userID)
    {                                                                                        // SQL query
        $query = "SELECT username, email, emailActivated                                                   
                  FROM user
                  WHERE userID = :userID";
        
        $db = DatabaseManager::getDB();                                                      // connects to db
        $stmt = $db->prepare($query);                                                        // preparing db
        $stmt->bindparam(':userID',$userID);                                                 // binding userID
        $stmt->execute();                                                                    // executing query
        $res = $stmt->fetch(PDO::FETCH_ASSOC);                                               // fetching results
        
        if(isset($res['username']) && isset($res['email']))                                  // if needed results
        {
            $user = new User($userID, $res['username'], $res['email'], $res['emailActivated']); // create new user
            return $user;                                                                    
        }
        else                                                                                // Needed data not achieved
        {
            return NULL;
        }
    }
    
    /**
     * Gets the ID of a user with a specified username
     * @param string $username A username
     * @return integer The user ID
     */
    public static function getUserID($username)
    {
        $query = "SELECT userID 
                  FROM user
                  WHERE username = :username";
        
        $db = DatabaseManager::getDB();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (isset($res['userID']))
        {
            return $res['userID'];
        }
        return NULL;
    }
    
    /**
     * Registers a new user based on inputdata from user--->controller
     * emailActivated is set to false as the user gets registered.
     * 
     * @param $username, $password, $email$, $emailActivated ,$publicTimeSchedule
     * @return boolean
     */
    public static function registerUser($username, $password, $email, $emailActivated ,$publicTimeSchedule)
    {
        if(!UserModel::userExists($username))
        {                                                                               // SQL query
            $query = "INSERT INTO user(username, password, email, emailActivated, publicTimeSchedule)
                      VALUES (:username, :password, :email, :emailActivated, :publicTimeSchedule)";
            
            $hashedPassword = hash_hmac('sha512', $password . UserModel::SALT, UserModel::SITEKEY); // Hashing password
            
            $db = DatabaseManager::getDB();
            $stmt = $db->prepare($query);                                               // Preparing database
            $stmt->bindparam(':username', $username);                                   // Binding variables
            $stmt->bindparam(':password', $hashedPassword);
            $stmt->bindparam(':email', $email);
            $stmt->bindparam(':emailActivated', $emailActivated);
            $stmt->bindparam(':publicTimeSchedule', $publicTimeSchedule);
            $stmt->execute();                                                           // Execute query
            
            return true;                                                                // User has been added to DB
        }
        
        else
        {
            return false;                                                               // Username is taken
        }
    }
    
    /**
     * Summary of newPassword
     * 
     * Comparing the current user password from $db to the current password requested from user.
     * If they match the users promt to a new password is accepted.
     * The new password overwrites the old in $db
     * 
     * Status: tested
     * 
     */
    public static function newPassword($userID, $oldPassword, $newPassword)
    {                                                                           // SQL query 
        $query = "SELECT password                                               
                  FROM user
                  WHERE userID = :userID";
        
        $db = DatabaseManager::getDB();                                         // sets up db connection
        $stmt = $db->prepare($query);                                           // preparing db for query
        $stmt->bindparam(':userID',$userID);                                    // binding parameters
        $stmt->execute();                                                       // executing query
        $res = $stmt->fetch(PDO::FETCH_ASSOC);                                  // fetching results
     
        if(isset($res['password']))
        {
            $oldPassword = hash_hmac('sha512', $oldPassword . UserModel::SALT, UserModel::SITEKEY);
                                               
            if(strcmp($oldPassword,$res['password']) == 0)                       // If current PW matches the one in db
            {                                                                    // Query for updating password
                $query2 = "UPDATE user                                       
                           SET password = :newPassword
                           WHERE userID = :userID";
                                                                                 // Hashing new PW with salt
                $hashedNewPassword = hash_hmac('sha512', $newPassword . UserModel::SALT, UserModel::SITEKEY);
                $db = DatabaseManager::getDB();
                $stmt2 = $db->prepare($query2);                                  // Preparing database for query
                $stmt2->bindparam(':newPassword', $hashedNewPassword);                 // Binding parameters
                $stmt2->bindparam(':userID', $userID);
                $stmt2->execute();                                               // Executing query
                
                return true;                                                     // The password was changed
            }
        }
       
        return false;
    }     
    
    public function submitPicture($userID, $picture)
    {
        $height = 200;
        $width = 200;
        $currentSize = array();
        
        $currentSize = getimagesize($picture);                                  // Returns array
        $heightFactor = $currentSize[0] / $height;                              // Original image height / heigth
        $widthFactor = $currentSize[1] / $width;
        
        $factor = ($heightFactor > $widthFactor)? $heightFactor : $widthFactor; // Wich factor to use for scaling?
        
        $newWidth = $width / $factor;                                           // New image width
        $newHeight = $height / $factor;                                         // New image height
        
        $image_p = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($image_p, $picture, 0, 0, 0, 0, $newWidth, $newHeight, $currentSize[1], $currentSize[0]);
        ob_start();
        imagepng($image_p);
        $imagevariable = ob_get_contents();
        ob_end_clean();
        
        $db = DatabaseManager::getDB();
        
        $query = "UPDATE user
                  SET profilePicture = :picture
                  WHERE userID = :userID";
        
        $stmt = $db->prepare($query);
        $stmt->bindparam(':picture',$imagevariable);
        $stmt->bindparam(':userID',$userID);
        $stmt->execute();
    }
}
?>