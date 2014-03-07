<?php
require_once('Template/Template.class.php');
require_once('NoteController.class.php');
require_once('SessionController.class.php');


$userID = SessionController::requestLoggedinID();
if (isset($_GET['noteid']) && isset($_GET['type']))
{
    NoteController::registerVote($_GET['noteid'], $userID, $_GET['type']);
}

$tpl = new Template();
$tpl->appendTemplate('RedirectBack');
$tpl->setValue('PAGE_TITLE', 'Vote Registered');
$tpl->display();
?>