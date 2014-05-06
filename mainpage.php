<?php
require_once('Application/Template/Template.class.php');
require_once('Application/Session/SessionController.class.php');
require_once('Application/MainPageController.class.php');
require_once('Application/MainPageScheduleController.class.php');
require_once('Application/BannerController.class.php');

$userID = SessionController::requestLoggedinID();

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'Mainpage');
$tpl->setValue('BANNER_TITLE', 'Your Higify');
$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'schedule', 'schedule_mainpage', 'editor'));
$tpl->setValue('JS', array('jquery-latest.min', 'menu', 'notefeedback', 'js/jquery-ui-1.10.4.custom', 'wgxpath.install', 'schedule_updater'));
$tpl->registerController(new BannerController());
$tpl->registerController(new MainPageController());
$tpl->appendTemplate('MainPageCenter');
$tpl->appendTemplate('MainPageSideMenu');
$tpl->registerController(new MainPageScheduleController($userID));
$tpl->appendTemplate('MainPageFooter');
$tpl->display();

?>