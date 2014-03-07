<?php
require_once('Template/IPageController.interface.php');
require_once('Schedule/ScheduleController.class.php');
require_once('SessionController.class.php');
require_once('UserController.class.php');
require_once('NoteType.class.php');
require_once('NoteListView.class.php');
require_once('NoteController.class.php');

class CreateNoteController implements IPageController
{   
    public function onDisplay()
    {
        $vals = array();
        $categoryOptions = array();
        $userID = SessionController::requestLoggedinID();
        $vals['SELECTED'] = false;
        
        if (isset($_GET['parent'])) // If this is a reply
        {
            $parentNote = NoteController::requestNote($_GET['parent']);
            if ($parentNote->getCategory()) // Add only if is not null
            {
                $categoryOptions[] = htmlspecialchars($parentNote->getCategory()); // Add the category for the parent to the category list
                $vals['SELECTED'] = htmlspecialchars($parentNote->getCategory());
            }
            else
            {
                $vals['SELECTED'] = 'Other';
            }
            
            $vals['ORIGINAL'] = new NoteListView(NULL, NoteType::NONE, $_GET['parent']);
            $vals['PARENT_ID'] = $_GET['parent'];
        }
        
        if (isset($_GET['category']))
            $vals['SELECTED'] = $_GET['category'];
        
        $attendingCourses = ScheduleController::getCourseElements($userID); 
        foreach ($attendingCourses as $code => $desc) // Format all the course descriptions to the HTML document
        {
            $description = htmlspecialchars($desc);
            if (!in_array($description, $categoryOptions))
                $categoryOptions[] = $description;
        }
        
        $categoryOptions[] = 'Other';
        
        if (!empty($_POST['content']) || (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])))
        {
            if (is_uploaded_file($_FILES['file']['tmp_name']))
            {
                $_POST['content'] = "Attachment";
            }   
            
            $public = !isset($_POST['notePrivate']);
                
            if (strlen($_POST['category']) == 0 || $_POST['category'] == 'Other')
                $category = NULL;
            else
                $category = $_POST['category'];
                
            if (isset($_GET['parent']))
                $noteID = NoteController::addNoteReply($_GET['parent'], $userID, $_POST['content'], $public, $category);
            else
                $noteID = NoteController::AddNote($userID, $_POST['content'], $category, $public);
            
            if(is_uploaded_file($_FILES['file']['tmp_name']))
            {
                NoteController::submitAttatchment($noteID, $_FILES['file']);
            }   
            
            header('Location: mainpage.php');
        }
        $vals['OPTIONS'] = $categoryOptions;
        
        return $vals;
    }
}

?>
