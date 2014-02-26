<?php
require_once('Template/Template.class.php');
require_once('WizzardController.class.php');

$tpl = new Template();
$tpl->appendTemplate('ScheduleWizzard');
$tpl->registerController(new WizzardController());
$tpl->display();
?>