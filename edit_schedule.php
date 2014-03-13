<?php

require_once('Application/Template/Template.class.php');
require_once('Application/Session/SessionController.class.php');
require_once('Application/MainPageController.class.php');
require_once('Application/MainPageScheduleController.class.php');
require_once('Application/BannerController.class.php');
require_once('Application/ScheduleWizzardController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');

if (isset($_GET['firsttime'])) // User has not setup the schedule yet
{
    $pageTitle = 'Schedule Setup';
    $bannerTitle = 'Setup Your Schedule';
}
else // Selected change schedule from settings or mainpage
{
    $pageTitle = 'Change Schedule';
    $bannerTitle = 'Change Your Schedule';
}


$tpl->setValue('PAGE_TITLE', $pageTitle);
$tpl->setValue('BANNER_TITLE', $bannerTitle);

$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'wizzard'));
$tpl->setValue('JS', array('jquery-latest.min', 'jquery.json-2.4.min', 'search_core', 'menu'));
$tpl->registerController(new BannerController());
$tpl->registerController(new ScheduleWizzardController());
$tpl->appendTemplate('ScheduleWizzard');
$tpl->appendTemplate('MainPageFooter');
$tpl->display();


?>