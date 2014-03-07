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
        $user = UserController::requestUserByID($userID);
        $vals = array();
        
        if ($userID !== NULL)
        {
            if (isset($_POST['public']))                                              
                UserController::updatePublicTime($userID, ($_POST['public'] == '1' ? true : false));
            
            $vals['PUBLIC'] = $user->hasPublicTimeTable() ? '1' : '0'; // With PHP, you'll never know...
            
            if (isset($_POST['email']))         
            {
                if (isset($_POST['emailverification']))
                {
                    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == true)  // If correct email string format
                    {
                        if ($_POST['email'] == $_POST['emailverification'])
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
                }
                else
                {
                    $picture = $_FILES['file']['tmp_name'];
                    UserController::requestPictureSubmit($picture);
                }
            }
            
            
            if (isset($_POST['newpassword']))
            {
               if (isset($_POST['oldpassword']))
               {
                   if(UserController::requestPasswordChange($userID,$_POST['oldpassword'],$_POST['newpassword']))
                   {
                        //  o/
                   }
                   else
                   {
                       $vals['ERROR_PASSWORD'] = new ErrorMessageView('Your current password was incorrect');
                   }
               }
               else
               {
                   $vals['ERROR_PASSWORD'] = new ErrorMessageView('You need to fill in your current password');
               }
            }
        }
        
        return $vals;
    }
}
?>