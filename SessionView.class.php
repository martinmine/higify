<?php
require_once('user/UserModel.class.php');

class SessionView
{
    function getUser($userID)
    {
        return UserModel::getUserByID($userID);
    }
}
?>