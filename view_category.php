<?php
require_once('Application/Template/Template.class.php');
require_once('Application/Note/NoteController.class.php');
require_once('Application/BannerController.class.php');
require_once('Application/NoteListCategoryController.class.php');

if (!isset($_GET['cat']))
    header('Location: mainpage.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'View Note Category');
$tpl->setValue('BANNER_TITLE', $_GET['cat']);
$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'schedule', 'schedule_mainpage', 'editor'));
$tpl->setValue('JS', array('jquery-latest.min', 'menu', 'noteloader', 'notefeedback', 'js/jquery-ui-1.10.4.custom', 'register_vote'));
$tpl->registerController(new BannerController());
$tpl->registerController(new NoteListCategoryController());
$tpl->appendTemplate('NoteCategory');
$tpl->display();
?>