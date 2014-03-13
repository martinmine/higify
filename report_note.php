<?php
require_once('Application/Template/Template.class.php');
require_once('Application/ReportNoteController.class.php');

$tpl = new Template();
$tpl->appendTemplate('RedirectBack');
$tpl->setValue('PAGE_TITLE', 'Vote Reported');
$tpl->registerController(new ReportNoteController());
$tpl->display();
?>