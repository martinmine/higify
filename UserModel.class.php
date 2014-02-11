<?php
require_once "DatabaseManager.class.php";
require_once "User.class.php";

class UserModel
{
    const SALT = 'abcfds11jhG';
    
    const SITEKEY = 'bbdsadacode';
    
    /**
     * Sends a query to the database to see if the
     * value of $username has a match.
     * @param $username
     * @return true,false 
     */
    public static function userExists($username)               // Boolean, checks if username is listed in database
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
     * @return User-object 
     */
    public static function getUser($username, $password)       
    {
        if(UserModel::userExists($username))
        {                                                                                           // SQL query
            $query = "SELECT userID, username, email                                    
                      FROM user
                      WHERE username = :username AND password = :password";
            
            $hashedPassword = hash_hmac('sha512', $password . UserModel::SALT, UserModel::SITEKEY); // Hashing password
           
            $db = DatabaseManager::getDB();
            $stmt = $db->prepare($query);                                                           // Preparing query
            $stmt->bindparam(':username', $username);                                   
            $stmt->bindparam(':password', $hashedPassword);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);                                            // Fetching associated
            
            if(isset($result['userID']) && isset($result['username']) && isset($result['email']))
            {
                $user = new User($result['userID'], $result['username'], $result['email']); // Creating new user object
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
     * @return $user obj 
     */
    public static function getUserByID($userID)
    {                                                                                        // SQL query
        $query = "SELECT username, email                                                   
                  FROM user
                  WHERE userID = :userID";
        
        $db = DatabaseManager::getDB();                                                      // connects to db
        $stmt = $db->prepare($query);                                                        // preparing db
        $stmt->bindparam(':userID',$userID);                                                 // binding userID
        $stmt->execute();                                                                    // executing query
        $res = $stmt->fetch(PDO::FETCH_ASSOC);                                               // fetching results
        
        if(isset($res['username']) && isset($res['email']))                                  // if needed results
        {
            $user = new User($userID, $res['username'], $res['email']);                      // create new user
            return $user;                                                                    
        }
        else                                                                                // Needed data not achieved
        {
            return NULL;
        }
    }
    
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
}

?>