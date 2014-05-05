<?php
require_once('Application/Template/Template.class.php');
require_once('Application/RegistrationController.class.php');

$tpl = new Template();
$tpl->appendTemplate('FrontPageHeader');
$tpl->setValue('PAGE_TITLE', 'Registration');
$tpl->setValue('JS', array('jquery-latest.min', 'registration-verifier', 'js/jquery-ui-1.10.4.custom'));
$tpl->registerController(new RegistrationController());
$tpl->appendTemplate('RegisterBody');
$tpl->appendTemplate('FrontPageFooter');
$tpl->display();

?>