<?php
require_once('Template/Template.class.php');
require_once('editProfileController.class.php');
require_once('BannerController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'Settings');
$tpl->setValue('BANNER_TITLE', 'Settings');
$tpl->registerController(new BannerController());
$tpl->registerController(new EditProfileController());
$tpl->setValue('CSS', array('mainpage', 'search', 'menu',));
$tpl->appendTemplate('EditProfile');
$tpl->appendTemplate('MainPageFooter');
$tpl->display();
?>