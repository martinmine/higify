<?php
require_once('Template/Template.class.php');
require_once('NoteController.class.php');
require_once('ViewNoteController.class.php');
require_once('BannerController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'View Note');
$tpl->setValue('BANNER_TITLE', 'View a Note');
$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'schedule', 'schedule_mainpage'));
$tpl->registerController(new BannerController());
$tpl->registerController(new ViewNoteController());
$tpl->appendTemplate('NoteReply');
$tpl->display();
?>