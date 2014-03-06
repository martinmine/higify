<?php

require_once('Template/Template.class.php');
require_once('MainPageController.class.php');
require_once('MainPageScheduleController.class.php');
require_once('SessionController.class.php');
require_once('BannerController.class.php');
require_once('ScheduleWizzardController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');

if (isset($_GET['firsttime']))
{
    $pageTitle = 'Schedule Setup';
    $bannerTitle = 'Setup Your Schedule';
}
else
{
    $pageTitle = 'Change Schedule';
    $bannerTitle = 'Change Your Schedule';
}


$tpl->setValue('PAGE_TITLE', $pageTitle);
$tpl->setValue('BANNER_TITLE', $bannerTitle);

$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'wizzard'));
$tpl->setValue('JS', array('jquery-latest.min', 'jquery.json-2.4.min', 'search_core'));
$tpl->registerController(new BannerController());
$tpl->registerController(new ScheduleWizzardController());
$tpl->appendTemplate('ScheduleWizzard');
$tpl->appendTemplate('MainPageFooter');
$tpl->display();


?>