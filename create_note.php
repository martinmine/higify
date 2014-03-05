<?php
require_once('Template/Template.class.php');
require_once('NoteController.class.php');
require_once('ViewNoteController.class.php');
require_once('BannerController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'Mainpage');
$tpl->setValue('BANNER_TITLE', 'Your Higify');
$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'create_note'));
$tpl->registerController(new BannerController());
$tpl->registerController(new CreateNoteController());
$tpl->appendTemplate('CreateNote');
$tpl->display();
?>