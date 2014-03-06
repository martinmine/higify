<?php

require_once('Template/Template.class.php');
require_once('SearchResultsPageController.class.php');
require_once('MainPageScheduleController.class.php');
require_once('BannerController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'search');
$tpl->setValue('BANNER_TITLE', 'Results');
$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'searchfound'));
$tpl->registerController(new BannerController());
$tpl->registerController(new SearchResultsPageController());
$tpl->appendTemplate('SearchResultsPageCenter');
$tpl->appendTemplate('MainPageFooter');
$tpl->display();


?>