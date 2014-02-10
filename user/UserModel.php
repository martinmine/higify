<?php
require_once "MyDB.php";
require_once "User.class.php";

class UserModel
{
    const SALT = 'abcfds11jhG';
    
    const SITEKEY = 'bbdsadacode';
    
    protected $db;                                        // PDO object handling database connection
    
    public function __construct()                         // Constructor
    {
        $this->db = openDB();                             // Connects to database
    }
    
    /**
     * Sends a query to the database to see if the
     * value of $username has a match.
     * @param $username
     * @return true,false 
     */
    public function userExists($username)               // Boolean, checks if username is listed in database
    {                                                   // SQL query
        $query = "SELECT username               
                  FROM user
                  WHERE username = :username";
        $stmt = $this->db->prepare($query);             // Preparing database
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
    public function getUser($username, $password)       
    {
        if(UserModel::userExists($username))
        {                                                                                // SQL query
            $query = "SELECT userID, username, email                                    
                      FROM user
                      WHERE username = :username AND password = :password";
            
            $hashedPassword = hash_hmac('sha512', $password . UserModel::SALT, UserModel::SITEKEY);        // Hashing password
           
            $stmt = $this->db->prepare($query);                                          // Preparing query
            $stmt->bindparam(':username', $username);                                   
            $stmt->bindparam(':password', $hashedPassword);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);                                    // Fetching associated
            
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
     * Registers a new user based on inputdata from user--->controller
     * emailActivated is set to false as the user gets registered.
     * 
     * @param $username, $password, $email$, $emailActivated ,$publicTimeSchedule
     * @return boolean
     */
    public function registerUser($username, $password, $email, $emailActivated ,$publicTimeSchedule)
    {
        if(!UserModel::userExists($username))
        {                                                                               // SQL query
            $query = "INSERT INTO user(username, password, email, emailActivated, publicTimeSchedule)
                      VALUES (:username, :password, :email, :emailActivated, :publicTimeSchedule)";
            
            $hashedPassword = hash_hmac('sha512', $password . UserModel::SALT, UserModel::SITEKEY); // Hashing password
            
            $stmt = $this->db->prepare($query);                                         // Preparing database
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
     */
    public function newPassword($userID, $oldPassword, $newPassword)
    {
            
    }
}


?>