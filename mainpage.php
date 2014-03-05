<?php

require_once('Template/Template.class.php');
require_once('MainPageController.class.php');
require_once('MainPageScheduleController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'Your Higify');
$tpl->setValue('CSS', array('mainpage', 'search', 'menu'));
$tpl->registerController(new MainPageController());
$tpl->appendTemplate('MainPageCenter');
$tpl->appendTemplate('MainPageSideMenu');
$tpl->registerController(new MainPageScheduleController());
$tpl->appendTemplate('MainPageFooter');
$tpl->display();

?>