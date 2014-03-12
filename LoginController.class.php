<?php
require_once('Template/IPageController.interface.php');
require_once('SessionController.class.php');
require_once('ErrorMessageView.class.php');
require_once('WarningMessageView.class.php');

/**
 * Reads the post data and sets the template variables
 */
class LoginController implements IPageController
{
    /**
     * Set all the values which are going to be displayed on the login page
     * @return Associated array of values to be shown on login page
     */
    public function onDisplay()
    {
        $user = SessionController::acquireSession(true);
        $vals = array();
        
        if (isset($_POST['username']) && isset($_POST['password']))
        {
            $user = UserController::requestUser($_POST['username'], $_POST['password']);
            
            if ($user !== NULL && $user->hasEmailActivated())
            {
                $rememberMe = (isset($_POST['rememberPassword']) && $_POST['rememberPassword'] == 'true');
                SessionController::setLoggedIn($user->getUserID(), $rememberMe);
            }
            else if ($user !== NULL && !$user->hasEmailActivated())
            {
                $vals['ERROR_MSG'] = new ErrorMessageView('Please activate your email address');
            }
            else
            {
                $vals['ERROR_MSG'] = new ErrorMessageView('Unknown username or password');
            }
        }
        else if (isset($_GET['registered']))
        {
            $vals['ERROR_MSG'] = new WarningMessageView('Your user has been registered. To sign in, follow the activation link which was sent to your email. If you did not receive an email, check your spam folder.');   
        }
        else if (isset($_GET['activated']))
        {
            $vals['ERROR_MSG'] = new WarningMessageView('Your user has been activated. You can sign in using the username and password you used while registering.');   
        }
        else if (isset($_GET['passwordsent']))
        {
            $vals['ERROR_MSG'] = new WarningMessageView('An email with instructions on how to reset your password has been sent. Please check your email. If you did not receive an email, check your spam folder.');   
        }
        else if (isset($_GET['passwordchanged']))
        {
            $vals['ERROR_MSG'] = new WarningMessageView('An email with your username and a new password has been sent to your email address. If you did not receive an email, check your spam folder.');   
        }
        
        if ($user !== NULL)
        {
            if ($user->hasPublicTimeTable() === NULL)
                header('Location: edit_schedule.php?firsttime');
            else
                header('Location: mainpage.php');
        }
        
        return $vals;
    }
}

?>