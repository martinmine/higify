<?php
require_once('SessionController.class.php');
require_once('NoteController.class.php');

$userID = SessionController::requestLoggedinID();
$voteType = ($_GET['type'] == 'upvote' ? 1 : 0);

NoteController::registerVote($userID, intval($_GET['note']), $voteType);

?>