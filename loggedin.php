<?php
/*
 * THIS PHP FILE IS OBSOLETE ONCE THE WEBSITE AFTER THIS SITE HAS BEEN IMPLEMENTED
 * THIS IS ONLY A UNIT TEST FOR DISPLAYING IF A USER IS SIGNED IN OR NOT
 */

require_once('SessionController.class.php');

$user = SessionController::acquireSession(true);

if ($user == null)
    echo 'User not logged in';
else
{
    echo 'User logged in:';
    print_r($user);
}
?>