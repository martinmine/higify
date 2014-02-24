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
        $user = SessionController::acquireSession(true);
        $vals = array();
     
        return $vals;
    }
}


?>