<?php

require_once('Template/Template.class.php');
require_once('SearchResultsPageController.class.php');

$tpl = new Template();
$tpl->appendTemplate('SearchResultsPageHeader');
$tpl->setValue('PAGE_TITLE', 'Search results');
$tpl->registerController(new SearchResultsPageController());
//$tpl->appendTemplate('SearchResultsPageTop');
//$tpl->appendTemplate('SearchResultsPageLeft');
$tpl->appendTemplate('SearchResultsPageCenter');
//$tpl->appendTemplate('MainPageScheduleContainer');
$tpl->appendTemplate('SearchResultsPageFooter');
$tpl->display();


?>