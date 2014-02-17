<?php
class User
{
    private $userID;    // type: int, containing the unique userID
 
    private $username;  // type: string, containing unique username
    
    private $email;     // type: string, containing unique email adress
    
    private $emailActivated; // type: boolean, true if user's email is activated
    
    public function __construct($userID, $username, $email, $emailActivated) // Constructor
    {
        $this->userID = $userID;
        $this->username = $username;
        $this->email = $email;
        $this->emailActivated = $emailActivated;
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
	 * Returns the state of user's email activation
	 * @return boolean True if email activated
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