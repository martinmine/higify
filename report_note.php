<?php
require_once('Template/Template.class.php');
require_once('ReportNoteController.class.php');

$tpl = new Template();
$tpl->appendTemplate('RedirectBack');
$tpl->setValue('PAGE_TITLE', 'Vote Reported');
$tpl->registerController(new ReportNoteController());
$tpl->display();
?>