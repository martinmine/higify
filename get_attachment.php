<?php
require_once('Application/Note/NoteController.class.php');

if (!isset($_GET['id']))
    header('Location: mainpage.php');
    
$attachmentData = NoteController::requestAttachment($_GET['id']);

if ($attachmentData === NULL)
    die('This attachment does not exist');

header('Content-length: ' . strlen($attachmentData[1]));
header('Content-type: application/force-download');
header('Content-Disposition: attachment; filename=' . $attachmentData[0]);

echo $attachmentData[1];
?>