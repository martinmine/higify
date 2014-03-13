<?php
/**
 * The vote status for a note
 */
class VoteStatus
{
    /**
     * Note has been downvoted by this user
     */
    const DOWNVOTED = 0;
    
    /**
     * Note has been upvoted by this user
     */
    const UPVOTED = 1;
    
    /**
     * User has not voted on this note
     */
    const NO_VOTE = 2;
}

?>