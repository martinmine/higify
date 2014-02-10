<?php
class User
{
    private $userID;    // type: int, containing the unique userID
 
    private $username;  // type: string, containing unique username
    
    private $email;     // type: string, containing unique email adress
    
    public function __construct($userID, $username, $email) // Constructor
    {
      $this->userID = $userID;
      $this->username = $username;
      $this->email = $email;
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