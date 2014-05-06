<?php
    require_once('Application/noteListView.class.php');
    require_once('Application/Session/SessionController.class.php');
    require_once('Application/Note/NoteType.class.php');
    
    $userID = SessionController::requestLoggedinID();
    
    $noteView = new noteListView($userID, NoteType::ALL);
    $noteView->generateHTML();
?>