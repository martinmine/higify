<?php
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('Template/IPageController.interface.php');

class BannerController implements IPageController
{
    public function onDisplay()
    {
        $userID = SessionController::requestLoggedinID();
        $user = UserController::requestUserByID($userID);
		
        $vals = array();
        $vals['USERNAME_BANNER'] = $user->getUsername();
        $vals['USER_ID'] = $userID;
        
        return $vals;
    }
}

?>