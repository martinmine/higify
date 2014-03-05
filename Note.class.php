<?php

/**
 * A class that stores information about a note
 *
 * @author  Thomas Mellemseter
 * @version 1.0
 */

class Note
{ 
	private $noteID;			//  @var int(10) notes uniq id.
	private $ownerID;			//  @var int(10) a reference to the owner by id.
	private $content;			//  @var text the content of the note.
	private $isPublic;			//  @var tinyint(1) 1 if note is public otherwise 0.
	private $published;			//  @timestamp time and date for when the note was published.
	private $ownerUsername;		//	@var varchar(30) username of the note owner.
    private $category;          //  @var string Which category this note was posted in
    private $points;            //  @var The vote balance/karma for the note
    private $replyCount;        //  @var Amount of replies
  
	/**
	 *  Constructs a new note setting all variables.
	 *  
	 *  @param $noteID the notes uniq ID.
	 *  @param $ownerID a refernece to the owner by id.
	 *  @param $content a string with the content.
	 *  @param $isPublic boolean value 0 or 1.
	 */
	public function __construct($noteID, $ownerID, $content, $isPublic, $published, $username, $category, $points, $replyCount)
	{
		$this->noteID = $noteID;
		$this->ownerID = $ownerID;
		$this->content = $content;
		$this->isPublic = $isPublic;
		$this->published = $published;
		$this->ownerUsername = $username;
        $this->category = $category;
        $this->points = $points;
        $this->replyCount = $replyCount;
	}
  
	/**
	 * Retrieves the notes unique id.
	 * 
	 * @return integer notes id.
	 */
	public function getNoteID()
	{
		return $this->noteID;
	}

	/**
	 * Retrieves the notes owner id.
	 * 
	 * @return integer owners id.
	 */  
	public function getOwnerID()
	{
		return $this->ownerID;
	}
	 
	/**
	 * Retrieves the content of the note.
	 * 
	 * @return text notes content.
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Retrieves boolean value whether the note
	 * is public or not.
	 *
	 * @return tinyint(1) 0 or 1.
	 */
	public function isPublic()
	{
		return $this->isPublic;
	}
	  
	/**
	 * Retrieves the timestamp for when the note
	 * was published.
	 *
	 * @return timestamp
	 */
	public function getTime()
	{
		return $this->published;
	}
	
	/**
	 * Retrieves the username from the note owner.
	 *
	 * @return varchar(30)
	 */
	public function getUsername()
	{
		return $this->ownerUsername;
	}
  
	/**
	 * Setting(overwriting/changing) the content
	 * of the note.
	 * 
	 * @param text the content of the note.
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * Changing the notes isPublic value.
	 * 
	 * @param tinyint(1) true/false.
	 */
	public function setIsPublic($isPublic)
	{
		$this->isPublic = $isPublic;
	}
    
    /**
     * Gets the category in which his note was posted.
     * If no category was made during posting, NULL is given
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
	
    /**
     * Returns the count of the replies that has been made to this note
     * @return integer
     */
    public function getReplyCount()
    {
        return $this->replyCount;
    }
    
    /**
     * Gets the karma/vote balance for this note
     * @return integer
     */
    public function getVoteBalance()
    {
        return $this->points;
    }
	/**
	 * Implements PHP 5's magic __toString() method
	 * 
	 * @return string a string encoding of the Note object.
	 */
	public function __toString()
	{
		return "noteID: {$this->noteID}, ownerID: {$this->ownerID}, "
				. "content: {$this->content}, isPublic; {$this->isPublic}"
				. "ownerName; {$this->ownerName}";
	}
}

?>