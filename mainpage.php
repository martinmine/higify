<?php

require_once('Template/Template.class.php');
require_once('MainPageController.class.php');
require_once('MainPageScheduleController.class.php');
require_once('SessionController.class.php');

$userID = SessionController::requestLoggedinID();

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'Index');
$tpl->registerController(new MainPageController());
$tpl->appendTemplate('MainPageTop');
$tpl->appendTemplate('MainPageLeft');
$tpl->appendTemplate('MainPageCenter');
$tpl->appendTemplate('MainPageScheduleContainer');
$tpl->registerController(new MainPageScheduleController($userID));
$tpl->appendTemplate('MainPageFooter');
$tpl->display();

?>