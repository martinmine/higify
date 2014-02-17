<?php
require_once('UserModel.class.php');

/**
 * Describes what to return to the user
 */
class SessionView
{
    function getUser($userID)
    {
        return UserModel::getUserByID($userID);
    }
}
?>