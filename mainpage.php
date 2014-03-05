<?php

require_once('Template/Template.class.php');
require_once('MainPageController.class.php');
require_once('MainPageScheduleController.class.php');
require_once('SessionController.class.php');

$userID = SessionController::requestLoggedinID();

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'Your Higify');
$tpl->setValue('CSS', array('mainpage', 'search', 'menu'));
$tpl->registerController(new MainPageController());
$tpl->appendTemplate('MainPageCenter');
<<<<<<< HEAD
$tpl->appendTemplate('MainPageSideMenu');
$tpl->registerController(new MainPageScheduleController());
=======
$tpl->appendTemplate('MainPageScheduleContainer');
$tpl->registerController(new MainPageScheduleController($userID));
>>>>>>> 71c620711f5381fa53b41c545494b46d19e21465
$tpl->appendTemplate('MainPageFooter');
$tpl->display();

?>