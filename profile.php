<?php
require_once('Application/Template/Template.class.php');
require_once('Application/User/UserController.class.php');
require_once('Application/ProfilePageController.class.php');
require_once('Application/MainPageScheduleController.class.php');
require_once('Application/BannerController.class.php');
require_once('Application/Session/SessionController.class.php');
require_once('Application/StalkerListView.class.php');


$user = UserController::requestUserByID($_GET['id']);

if ($user === NULL)
{
    header('Location: mainpage.php');
    exit;
}

$title = $user->getUsername();
$userID = $user->getUserID();
$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', $title);
$tpl->setValue('BANNER_TITLE', $title);
$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'schedule', 'schedule_mainpage', 'profile', 'editor'));
$tpl->setValue('JS', array('jquery-latest.min', 'menu', 'notefeedback', 'noteloader', 'stalk'));
$tpl->registerController(new BannerController());
$tpl->registerController(new ProfilePageController());
$tpl->appendTemplate('ProfilePageCenter');
    
if ($user->hasPublicTimeTable())
	$tpl->registerController(new MainPageScheduleController($userID));
else
    $tpl->setValue('SCHEDULE', 'This user has no public schedule');

$tpl->setValue('DISPLAY_STALKBTN', $userID != SessionController::requestLoggedinID());
$tpl->setValue('STALKER_ELEMENTS', new StalkerListView(UserController::requestStalkers($userID)));
$tpl->setValue('STALKING', UserController::getStalkingStatus($userID, SessionController::requestLoggedinID()));
$tpl->appendTemplate('MainPageFooter');
$tpl->display();

?>