<?php
require_once('Template/IPageController.interface.php');
require_once('SessionController.class.php');
require_once('user/UserModel.class.php');
require_once('ErrorMessageView.class.php');
require_once('WarningMessageView.class.php');

class LoginController implements IPageController
{
    public function onDisplay()
    {
        $user = SessionController::acquireSession(true);
        $vals = array();
        
        if ($user == NULL && isset($_POST['username']) && isset($_POST['password']))
        {
            $user = UserModel::getUser($_POST['username'], $_POST['password']);
            
            if ($user !== NULL && $user->hasEmailActivated())
            {
                SessionController::setLoggedIn($user->getUserID());
            }
            else if ($user !== NULL && !$user->hasEmailActivated())
            {
                $warningView = new WarningMessageView('Please activate your email address');
            }
            else
            {
                $vals['ERROR_MSG'] = new ErrorMessageView('Unknown username or password');    
            }
        }
        
        return $vals;
    }
}

?>