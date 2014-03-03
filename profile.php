<?php

require_once('Template/Template.class.php');
require_once('ProfilePageController.class.php');
require_once('UserController.class.php');

$user = UserController::requestUserByID($_GET['id']);

if ($user !== NULL)
{
	$title = $user->getUsername();

	$tpl = new Template();
	$tpl->appendTemplate('ProfilePageHeader');
	$tpl->setValue('PAGE_TITLE', $title);
	$tpl->registerController(new ProfilePageController());
	$tpl->appendTemplate('ProfilePageBanner');
	$tpl->appendTemplate('ProfilePageLeft');
	$tpl->appendTemplate('ProfilePageCenter');
	$tpl->appendTemplate('ProfilePageFooter');
	$tpl->display();
}
else
{
	header('Location: mainpage.php');
}

?>