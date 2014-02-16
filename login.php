<?php
require_once('Template/Template.class.php');
require_once('LoginController.php');

$tpl = new Template();
$tpl->appendTemplate('LoginHeader');
$tpl->registerController(new LoginController());
$tpl->appendTemplate('LoginBody');
$tpl->appendTemplate('LoginFooter');
$tpl->display();

?>