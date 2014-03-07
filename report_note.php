<?php
require_once('Template/Template.class.php');
require_once('SessionController.class.php');
require_once('NoteController.class.php');

$userID = SessionController::requestLoggedinID();
if (isset($_GET['id']))
{
    NoteController::reportNote($_GET['id'], $userID);
}

$tpl = new Template();
$tpl->appendTemplate('RedirectBack');
$tpl->setValue('PAGE_TITLE', 'Vote Reported');
$tpl->display();
?>