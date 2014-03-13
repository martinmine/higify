<?php

require_once('Application/Template/Template.class.php');
require_once('Application/SearchResultsPageController.class.php');
require_once('Application/MainPageScheduleController.class.php');
require_once('Application/BannerController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'search');
$tpl->setValue('BANNER_TITLE', 'Results');
$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'searchfound'));
$tpl->setValue('JS', array('jquery-latest.min', 'menu'));
$tpl->registerController(new BannerController());
$tpl->registerController(new SearchResultsPageController());
$tpl->appendTemplate('SearchResultsPageCenter');
$tpl->appendTemplate('MainPageFooter');
$tpl->display();


?>