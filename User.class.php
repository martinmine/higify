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
	 *	Retrieves the usersID.
	 *
	 *	@return $userID integer.
	 */
	public function getUserID()
	{
		return $this->userID;
	}
	
	/**
	 * Retrieves the username.
	 *
	 * @return $username varchar(30). 
	 */
	public function getUsername()
	{
		return $this->username;
	}
	
	/**
	 * Retrieves the users email address.
	 *
	 * @returns $email varchar(50).
	 */
	public function getEmail()
	{
		return $this->email;
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