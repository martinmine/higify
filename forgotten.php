<?php
require_once('Application/Template/Template.class.php');
require_once('Application/ForgottenPasswordController.class.php');

$tpl = new Template();
$tpl->appendTemplate('FrontPageHeader');
$tpl->setValue('PAGE_TITLE', 'Forgotten password');
$tpl->registerController(new ForgottenPasswordController());
$tpl->appendTemplate('ForgottenPasswordBody');
$tpl->appendTemplate('FrontPageFooter');
$tpl->display();

?>