<?php
    require_once('Application/NoteListView.class.php');
    require_once('Application/Session/SessionController.class.php');
    require_once('Application/Note/NoteType.class.php');
 
    //public function __construct($noteOwnerID = NULL, $noteType = NoteType::NONE, $parentNoteID = NULL, $category = NULL, $noteCounter = 0)
  
   
    if(isset($_POST['profileID']) && isset($_POST['noteCounter']))
    {
        $profileID = $_POST['profileID'];
        $noteCounter = $_POST['noteCounter'];
        $noteView = new noteListView($profileID, NoteType::PUBLIC_ONLY, NULL, NULL, $noteCounter);
    }
    
    else if (isset($_POST['categoryID']) && isset($_POST['noteCounter']))
    {
        $categoryID = $_POST['categoryID'];
        $noteCounter = $_POST['noteCounter'];
        $noteView = new noteListView(NULL, NoteType::NONE, NULL, $categoryID, $noteCounter);
    }
    
    else if (isset($_POST['noteID']) && isset($_POST['noteCounter']))
    {
        $noteID = $_POST['noteID'];
        $noteCounter = $_POST['noteCounter'];
        $noteView = new noteListView(NULL, NoteType::REPLY, $noteID, NULL, $noteCounter);
    }
    
    else 
    {
        $userID = SessionController::requestLoggedinID();
        $noteCounter = $_POST['noteCounter'];
        $noteView = new noteListView($userID, NoteType::ALL, NULL, NULL, $noteCounter);
    }
    
    $noteView->generateHTML();
?>