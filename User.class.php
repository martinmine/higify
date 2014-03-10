<?php
class User
{
    private $userID;    // type: int, containing the unique userID
 
    private $username;  // type: string, containing unique username
    
    private $email;     // type: string, containing unique email adress
    
    private $emailActivated; // type: boolean, true if user's email is activated
    
    private $publicTimeSchedule; // type: boolean, true if user has set timetable to public
    
    private $rank; // type: integer or null, contains the rank of the user if has any rank
    
    public function __construct($userID, $username, $email, $emailActivated, $scheduleState, $rank) // Constructor
    {
        $this->userID = $userID;
        $this->username = $username;
        $this->email = $email;
        $this->emailActivated = $emailActivated;
        $this->publicTimeSchedule = $scheduleState;
        $this->rank = $rank;
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
    * Gets the rank of a user. Is null if has no rank.
    *
    * @returns integer 
    */
    public function getRank()
    {
        return $this->rank;
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
	 * Gets the state of the time schedule for the user
     * True: Schedule can be viewed by anyone
     * False: Schedule private
     * DNBULL: User has not yet signed in and depends setting up the time schedule
	 * @return mixed
	 */
	public function hasPublicTimeTable()
    {
        return $this->publicTimeSchedule;
    }
}
?>