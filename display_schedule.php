<?php
require_once('Template/Template.class.php');
require_once('BannerController.class.php');
require_once('DisplayScheduleController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');

$tpl->setValue('PAGE_TITLE', 'Schedule');
$tpl->setValue('BANNER_TITLE', 'Schedule For The Week');

$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'time_schedule'));
$tpl->setValue('JS', array('jquery-latest.min', 'jquery.json-2.4.min', 'wgxpath.install', 'time_schedule'));
$tpl->registerController(new BannerController());
$tpl->registerController(new DisplayScheduleController());
$tpl->appendTemplate('WeekSchedule');
$tpl->appendTemplate('MainPageFooter');
$tpl->display();
?>

