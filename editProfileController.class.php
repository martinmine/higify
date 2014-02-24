<?php
require_once('Template/IPageController.interface.php');
require_once('SessionController.class.php');
require_once('ErrorMessageView.class.php');
require_once('WarningMessageView.class.php');
require_once('UserController.class.php');


class EditProfileController implements IPageController
{
    public function onDisplay()
    {
        $userID = SessionController::requestLoggedinID();
        $vals = array();
        
        /*
         * TODO:::: Check for current state of publictimeschedule 
         * 
         * */
        if ($userID !== NULL)
        {
            
            if (isset($_POST['public']))                                              
            {
                if ($_POST['public'] == true)                                       // If checkbox is set for public
                {                                                                   // timeschedule
                    UserController::updatePublicTime($userID, $_POST['public']);
                }
            }
            
            
            if (isset($_POST['email']))         
            {
                if (isset($_POST['emailverification']))
                {
                    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === true)  // If correct email string format
                    {
                        if ($_POST['email'] === $_POST['emailverification'])
                        {
                            UserController::updateEmail($userID,$_POST['email']);     // Updates users email
                        }
                        
                        else
                        {
                            $vals['ERROR_EMAIL'] = new ErrorMessageView('Emails did not match');
                        }
                    }
                    
                    else
                    {
                        $vals['ERROR_EMAIL'] = new ErrorMessageView('Invalid email format');
                    }
                }
                
                else
                {
                    $vals['ERROR_EMAIL'] = new ErrorMessageView('You need to JUSTIFY your email address');
                }
            }
            
            
            if (isset($_FILES['file']))                                             
            {
                if ($_FILES['file']["error"] > 0)
                {
                    $vals['ERROR_PROFILEPIC'] = new ErrorMessageView($_FILES["file"]["error"]);
                    echo $vals['ERROR_PROFILEPIC']; // test                    
                }
                
                else
                {
                    $picture = $_FILES['file']['tmp_name'];
                    UserController::requestPictureSubmit($picture);
                }
            }
        }
        
        
        return $vals;
    }
}


?>