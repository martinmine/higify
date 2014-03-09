<?php

require_once('Template/Template.class.php');
require_once('ProfilePageController.class.php');
require_once('UserController.class.php');
require_once('MainPageScheduleController.class.php');
require_once('BannerController.class.php');

$user = UserController::requestUserByID($_GET['id']);

if ($user !== NULL)
{
	$title = $user->getUsername();
	$userID = $user->getUserID();
	
	$tpl = new Template();
	$tpl->appendTemplate('MainPageHeader');
	$tpl->setValue('PAGE_TITLE', $title);
	$tpl->setValue('BANNER_TITLE', $title);
	$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'profile', 'schedule', 'schedule_mainpage'));
    $tpl->setValue('JS', array('jquery-latest.min', 'menu'));
	$tpl->registerController(new BannerController());
	$tpl->registerController(new ProfilePageController());
	$tpl->appendTemplate('ProfilePageLeft');
	$tpl->appendTemplate('ProfilePageCenter');
	$tpl->appendTemplate('MainPageScheduleContainer');
	$tpl->registerController(new MainPageScheduleController($userID));
	$tpl->appendTemplate('MainPageFooter');
	$tpl->display();
}
else
{
	header('Location: mainpage.php');
}

?>