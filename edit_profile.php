<?php
require_once('Application/Template/Template.class.php');
require_once('Application/EditProfileController.class.php');
require_once('Application/BannerController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'Settings');
$tpl->setValue('BANNER_TITLE', 'Settings');
$tpl->registerController(new BannerController());
$tpl->registerController(new EditProfileController());
$tpl->setValue('CSS', array('mainpage', 'search', 'menu',));
$tpl->setValue('JS', array('jquery-latest.min', 'menu'));
$tpl->appendTemplate('EditProfile');
$tpl->appendTemplate('MainPageFooter');
$tpl->display();
?>