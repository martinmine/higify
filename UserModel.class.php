<?php
require_once ('DatabaseManager.class.php');
require_once ('User.class.php');


class UserModel
{
    const SALT = 'abcfds11jhG';
    
    const SITEKEY = 'n8eyr2nsdasd23119bh91b';
    
    /**
     * Sends a query to the database to see if the
     * value of $username has a match.
     * @param $username
     * @return true,false
     */
    public static function userExists($username)        // Boolean, checks if username is listed in database
    {                                                   // SQL query
        $query = "SELECT username               
                  FROM User
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
    
    private static function fetchUser($row)
    {
        return new User($row['userID'], $row['username'], $row['email'],       // Creating new user object
                        $row['emailActivated'], $row['publicTimeSchedule'], $row['rank']);          
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
            $query = "SELECT User.userID, username, email, emailActivated, password, publicTimeSchedule, rank
                      FROM User
                      LEFT OUTER JOIN UserRank ON(UserRank.userID = User.userID)
                      WHERE username = :username";
            
          
           
            $db = DatabaseManager::getDB();
            $stmt = $db->prepare($query);                                                           // Preparing query
            $stmt->bindparam(':username', $username);                                   
            $stmt->execute();
            
            $result = array();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);                                            // Fetching associated
            
            if ($result['userID'])                                                                 
            {                                                                                    // Hashing password
                if ($result['password'] == hash_hmac('sha512', $result['userID'] . $password . UserModel::SALT, UserModel::SITEKEY))
                    return self::fetchUser($result);
            }
        }
                 
        return NULL;                                                                       // Something went wrong!
    }
    
    /**
     * Fetches a user using the unique email adress
     * 
     * @param $email
     * @return
     */
    public static function getUserByEmail($email)
    {
        $query = "SELECT User.userID, username, email, emailActivated, publicTimeSchedule, rank
                      FROM User
                      LEFT OUTER JOIN UserRank ON(UserRank.userID = User.userID)
                      WHERE email = :email";
        
        $db = DatabaseManager::getDB();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $result = array();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['userID'] && $result['username'])
        {
            return self::fetchUser($result);
        }
        
        return NULL;
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
        $query = "SELECT User.userID, username, email, emailActivated, publicTimeSchedule, rank
                  FROM User
                  LEFT OUTER JOIN UserRank ON(UserRank.userID = User.userID)
                  WHERE User.userID = :userID";
        
        $db = DatabaseManager::getDB();                                                      // connects to db
        $stmt = $db->prepare($query);                                                        // preparing db
        $stmt->bindparam(':userID',$userID);                                                 // binding userID
        $stmt->execute();                                                                    // executing query
        $res = $stmt->fetch(PDO::FETCH_ASSOC);                                               // fetching results
        
        if(isset($res['username']) && isset($res['email']))                                  // if needed results
        {
            return self::fetchUser($res);                                                             
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
                  FROM User
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
        $query = "INSERT INTO User(username, password, email, emailActivated, publicTimeSchedule)
                    VALUES (:username, :password, :email, :emailActivated, :publicTimeSchedule)";
        
        $dummyPW = "xxx";
  
        $db = DatabaseManager::getDB();
        $stmt = $db->prepare($query);                                               // Preparing database
        $stmt->bindparam(':username', $username);                                   // Binding variables
        $stmt->bindparam(':password', $dummyPW);
        $stmt->bindparam(':email', $email);
        $stmt->bindparam(':emailActivated', $emailActivated);
		$stmt->bindparam(':publicTimeSchedule', $publicTimeSchedule);
        $stmt->execute();                                                           // Execute query
            
        $userID = $db->lastInsertId();
        $hashedPassword = hash_hmac('sha512', $userID . $password . UserModel::SALT, UserModel::SITEKEY); // Hashing password
        
                                                                        // Seperate query needed to hash pw with userID
        $query2 = "UPDATE User                                                      
                   SET password = :hashedPassword
                   WHERE userID = :userID";
        
        $stmt2 = $db->prepare($query2);
        $stmt2->bindparam(':hashedPassword', $hashedPassword);
        $stmt2->bindparam(':userID', $userID);
        $stmt2->execute();
        
        return $db->lastInsertId();
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
                  FROM User
                  WHERE userID = :userID";
        
        $db = DatabaseManager::getDB();                                         // sets up db connection
        $stmt = $db->prepare($query);                                           // preparing db for query
        $stmt->bindparam(':userID',$userID);                                    // binding parameters
        $stmt->execute();                                                       // executing query
        $res = $stmt->fetch(PDO::FETCH_ASSOC);                                  // fetching results
     
        if(isset($res['password']))
        {
            $oldPassword = hash_hmac('sha512', $userID . $oldPassword . UserModel::SALT, UserModel::SITEKEY);
                                               
            if(strcmp($oldPassword,$res['password']) == 0)                       // If current PW matches the one in db
            {                                                                    // Query for updating password
                self::setPassword($userID, $newPassword);                        // Set the new password
                return true;                                                     // The password was changed
            }
        }
  
        return false;
    }     
    
    /**
     * Sets the password for the user
     * @param integer $userID The users ID
     * @param string  $newPassword The new password in cleartext
     */
    public static function setPassword($userID, $newPassword)
    {
        $hashedNewPassword = hash_hmac('sha512', $userID . $newPassword . UserModel::SALT, UserModel::SITEKEY);
        $db = DatabaseManager::getDB();
        $stmt = $db->prepare("UPDATE User                                       
                               SET password = :newPassword
                               WHERE userID = :userID");                 // Preparing database for query
        $stmt->bindparam(':newPassword', $hashedNewPassword);           // Binding parameters
        $stmt->bindparam(':userID', $userID);
        $stmt->execute();                                               // Executing query
    }
    
    /**
     * Scales a picture and submits to database 
     * Picture format: .PNG
     * 
     * @param $userID
     * @param $picture
     */
    public static function submitPicture($userID, $picture)
    {
        $height = 200;
        $width = 200;
        $imagevariable = 0;
        
        list($originalWidth, $originalHeight) = getimagesize($picture);         // Returns array with height and width
        $heightFactor = $originalHeight / $height;                              // Original image height / heigth
        $widthFactor = $originalWidth / $width;
        
        $factor = ($heightFactor > $widthFactor)? $heightFactor : $widthFactor; // Which factor to use for scaling?
        
        $newWidth = $originalWidth / $factor;                                   // Calculating new image width
        $newHeight = $originalHeight / $factor;                                 // Calculating new image height
        $image = imagecreatefromstring(file_get_contents($picture));
        $newImage = imagecreatetruecolor($newWidth, $newHeight);                // Creating new image frame                                                        
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
        ob_start();                                                             // Turn on output buffering
        imagepng($newImage);                                                    // Creating .png image
        $imagevariable = ob_get_contents();                                     // Retrieving image from stream
        ob_end_clean();                                                         // End stream
        
        $db = DatabaseManager::getDB();                                         
        
        $query = "UPDATE User
                  SET profilePicture = :picture
                  WHERE userID = :userID";
        
        $stmt = $db->prepare($query);
        $stmt->bindparam(':picture',$imagevariable);
        $stmt->bindparam(':userID',$userID);
        $stmt->execute();
    }
    
    
    /**
     * Sets email to activated 
     * 
     * @param $userID
     */
    public static function activateEmail($userID)
    {
        $pdo = DatabaseManager::getDB();
        $query = $pdo->prepare('UPDATE User 
                                SET emailActivated = 1 
                                WHERE userID = :userID');
        
        $query->bindParam('userID', $userID);
        $query->execute();
    }
    
    public static function newEmail($userID, $newEmail)
    {
        $query = "UPDATE User 
                  SET email = :email
                  WHERE userID = :userID";
        
        $db = DatabaseManager::getDB();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $newEmail);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
    }
    
    public static function setPublicTimeSchedule($userID, $bool)
    {
        $query = "UPDATE User 
                  SET publicTimeSchedule = :bool
                  WHERE userID = :userID";
        
        $db = DatabaseManager::getDB();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':bool', $bool);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
    }

    /**
     * Selects the profilepicture from user matching userID
     * 
     * @param $userID
     * @return picture
     */
    public static function fetchProfilePicture($userID)
    {
        $query = "SELECT profilePicture
                  FROM User
                  WHERE userID = :userID";
        $db = DatabaseManager::getDB();
        
        $stmt = $db->prepare($query);
        $stmt->bindparam(':userID',$userID);
        $stmt->execute();
        
        $picture = array();
        $picture = $stmt->fetch(PDO::FETCH_ASSOC);
        if (isset($picture['profilePicture']))
            return $picture['profilePicture'];
        
        return NULL;
    }
	
	public static function getSearchResults($username)
	{
		$term = "%" . $username . "%";
		
		$res = array();
		$db = DatabaseManager::getDB();
		$query = "SELECT userID, username
			        FROM User
					WHERE username LIKE (:username)";
		
		$stmt = $db->prepare($query);
		$stmt->bindParam(':username', $term);
		$stmt->execute();
		
		$hits = array();
      
		while ($res = $stmt->fetch(PDO::FETCH_ASSOC))
		{
            $hits[] = $res;  
		}
	
		return $hits;
	}
}
?>