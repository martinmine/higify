<?php
class User
{
    private $userID;    // type: int, containing the unique userID
 
    private $username;  // type: string, containing unique username
    
    private $email;     // type: string, containing unique email adress
    
    private $emailActivated; // type: boolean, if a user has activated the email
    
    public function __construct($userID, $username, $email, $emailActivated) // Constructor
    {
      $this->userID = $userID;
      $this->username = $username;
      $this->email = $email;
      $this->emailActivated = $emailActivated;
    }
    
    /**
     * Returns true/false i the user has activated the email address
     * @return boolean Email is activated
     */
    public function hasEmailActivated()
    {
        return $this->emailActivated;
    }
    
    /**
     * Summary of display
     * TEST FUNCTION
     * TODO: DELETE IT
     */
    public function display()
    {
        $res = 'id: ' . $this->userID . '   username: ' . $this->username 
                      . '   email: ' . $this->email;
        echo $res;
    }
}
?>