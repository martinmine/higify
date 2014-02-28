<?php

require_once('Template/Template.class.php');
require_once('ProfilePageController.class.php');

$tpl = new Template();
$tpl->appendTemplate('ProfilePageHeader');
$tpl->setValue('PAGE_TITTLE', 'Profile');
$tpl->registerController(new ProfilePageController());
$tpl->appendTemplate('ProfilePageCenter');
$tpl->appendTemplate('ProfilePageFooter');
$tpl->display();

?>