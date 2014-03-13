<?php
require_once('Application/Template/Template.class.php');
require_once('Application/LoginController.class.php');

$tpl = new Template();
$tpl->appendTemplate('FrontPageHeader');
$tpl->setValue('PAGE_TITLE', 'Login');
$tpl->registerController(new LoginController());
$tpl->appendTemplate('LoginBody');
$tpl->appendTemplate('FrontPageFooter');
$tpl->display();

?>