<?php
require_once('NoteController.class.php');
require_once('SessionController.class.php');

$userID = SessionController::requestLoggedinID();
if (isset($_GET['noteid']) && isset($_GET['type']))
{
    NoteController::registerVote($_GET['noteid'], $userID, $_GET['type']);
}

?>
<!DOCTYPE HTML>
<html>
<script language=”javascript”>
window.history.back(-1);
</script>
</html>
