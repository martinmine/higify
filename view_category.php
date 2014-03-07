<?php
require_once('Template/Template.class.php');
require_once('NoteController.class.php');
require_once('BannerController.class.php');
require_once('NoteListCategoryController.class.php');

if (!isset($_GET['cat']))
    header('Location: mainpage.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'View Note Category');
$tpl->setValue('BANNER_TITLE', $_GET['cat']);
$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'schedule', 'schedule_mainpage'));
$tpl->registerController(new BannerController());
$tpl->registerController(new NoteListCategoryController());
$tpl->appendTemplate('NoteCategory');
$tpl->display();
?>