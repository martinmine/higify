<?php

require_once('Template/Template.class.php');
require_once('MainPageController.class.php');
require_once('MainPageScheduleController.class.php');
require_once('SessionController.class.php');
require_once('BannerController.class.php');

$userID = SessionController::requestLoggedinID();

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'Mainpage');
$tpl->setValue('BANNER_TITLE', 'Your Higify');
$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'schedule', 'schedule_mainpage'));
$tpl->registerController(new BannerController());
$tpl->registerController(new MainPageController());
$tpl->appendTemplate('MainPageCenter');
$tpl->appendTemplate('MainPageSideMenu');
$tpl->registerController(new MainPageScheduleController($userID));
$tpl->display();

?>