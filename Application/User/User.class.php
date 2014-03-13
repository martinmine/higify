<?php
class User
{
	/**
	 * Users ID
	 * @var integer
	 */
    private $userID;
 
 	/**
 	 * Users username
 	 * @var string
 	 */
    private $username;
    
    /**
     * The users email address
     * @var string
     */
    private $email;
    
    /**
     * Indicates if the users email address is activated or not
     * @var boolean
     */
    private $emailActivated;
    
    /**
     * Inficates if the user has a public or private schedule
     * @var boolean
     */
    private $publicTimeSchedule;
    
    /**
     * The rank of the user if the user has any
     * @var integer
     */
    private $rank;
    
    /**
     * Constructs a new User
     * @param integer $userID         ID
     * @param string $username        Username
     * @param string $email           Email
     * @param string $emailActivated  If the user has activated their email
     * @param boolean $scheduleState  Public or private schedule
     * @param integer $rank           The users rank if has any
     */
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
	 * @return mixed
     *         True: Schedule can be viewed by anyone
     *         False: Schedule private
     *         NULL: User has not yet signed in and depends setting up the time schedule
	 * 
	 */
	public function hasPublicTimeTable()
    {
        return $this->publicTimeSchedule;
    }
}
?>