<?php
require_once('Application/Template/Template.class.php');
require_once('Application/Note/NoteController.class.php');
require_once('Application/ViewNoteController.class.php');
require_once('Application/BannerController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'View Note');
$tpl->setValue('BANNER_TITLE', 'View a Note');
$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'schedule', 'schedule_mainpage', 'editor'));
$tpl->setValue('JS', array('jquery-latest.min', 'menu', 'noteloader', 'register_vote'));
$tpl->registerController(new BannerController());
$tpl->registerController(new ViewNoteController());
$tpl->appendTemplate('NoteReply');
$tpl->display();
?>