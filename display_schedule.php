<?php
require_once('Application/Template/Template.class.php');
require_once('Application/BannerController.class.php');
require_once('Application/DisplayScheduleController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');

$tpl->setValue('PAGE_TITLE', 'Schedule');
$tpl->setValue('BANNER_TITLE', 'Schedule For The Week');

$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'time_schedule'));
$tpl->setValue('JS', array('jquery-latest.min', 'jquery.json-2.4.min', 'wgxpath.install', 'time_schedule', 'jquery-latest.min', 'menu'));
$tpl->registerController(new BannerController());
$tpl->registerController(new DisplayScheduleController(isset($_GET['week']) ? $_GET['week'] : date('W')));
$tpl->appendTemplate('WeekSchedule');
$tpl->appendTemplate('MainPageFooter');
$tpl->display();
?>

