<?php

/**
 * A class that stores information about a note
 *
 * @author  Thomas Mellemseter
 * @version 1.0
 */

class Note
{ 
	/**
	 * ID of thenote
	 * @var integer
	 */
	private $noteID;

	/**
	 * A reference to the notes owner ID
	 * @var integer
	 */
	private $ownerID;

	/**
	 * The content of the note
	 * @var string
	 */
	private $content;

	/**
	 * If a note is public or not
	 * @var boolean
	 */
	private $isPublic;

	/**
	 * When the note was published
	 * @var string
	 */
	private $published;

	/**
	 * Username of the note owner
	 * @var string
	 */
	private $ownerUsername;

	/**
	 * Which category which this note was posted in
	 * @var string
	 */
    private $category;

    /**
     * The vote balance/karma for the note
     * @var integer
     */
    private $points;

    /**
     * Amount of replies
     * @var integer
     */
    private $replyCount;

    /**
     * The username of the parent post
     * @var string
     */
    private $originalPoster;

    /**
     * The note ID of the parent note
     * @var integer
     */
    private $parentID;
    
	/**
	 *  Constructs a new note setting all variables.
	 *  
	 *  @param integer $noteID the notes unique ID.
	 *  @param integer $ownerID a refernece to the owner by id.
	 *  @param string  $content Content of the note
	 *  @param boolean $isPublic Indicating wether the note is public or not
     *  @param string  $published Time-stamp for when the note was published
     *  @param string  $username OP's username
     *  @param string  $category Category in which the post was posted
     *  @param integer $points Point balance for the note
     *  @param string  $op Username of OP of parent post
     *  @param integer $parentID The ID of the parent post, NULL if has no parent
     *  @param integer $replyCount Amount of replies made to the note
	 */
	public function __construct($noteID, $ownerID, $content, $isPublic, $published, $username, $category, $points, $op, $parentID, $replyCount)
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
        $this->originalPoster = $op;
        $this->parentID = $parentID;
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
	 * Retrieves the formated timestamp for when the note
	 * was published in the format d M H:i
	 *
	 * @return timestamp
	 */
	public function getTime()
	{
        return date('d M H:i', strtotime($this->published));
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
     * Sets the categry of the note
     * @param string $category Note category, NULL if has no category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
     * Gets the username of the parent post
     * @return string Username of parent poster, NULL if has no parent
     */
    public function getOriginalPoster()
    {
        return $this->originalPoster;
    }
    
    /**
     * Gets the ID of the parent post
     * @return integer The ID of the parent note, NULL if has no parent
     */
    public function getParentID()
    {
        return $this->parentID;
    }
    
    /**
     * Gets the karma/vote balance for this note
     * @return integer
     */
    public function getVoteBalance()
    {
        return $this->points;
    }
}

?>