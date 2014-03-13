<?php
require_once('Application/Template/Template.class.php');
require_once('Application/Note/NoteController.class.php');
require_once('Application/ViewNoteController.class.php');
require_once('Application/BannerController.class.php');
require_once('Application/CreateNoteController.class.php');

$tpl = new Template();
$tpl->appendTemplate('MainPageHeader');
$tpl->setValue('PAGE_TITLE', 'Create Note');
$tpl->setValue('BANNER_TITLE', isset($_GET['parent']) ? 'Reply to a Note' : 'Create a New Note');
$tpl->setValue('CSS', array('mainpage', 'search', 'menu', 'create_note', 'xing-wysihtml5/formater', 'formater', 'editor'));
$tpl->setValue('JS', array('xing-wysihtml5/parser_rules/advanced','xing-wysihtml5/dist/wysihtml5-0.3.0', 'jquery-latest.min', 'menu'));
$tpl->registerController(new BannerController());
$tpl->registerController(new CreateNoteController());
$tpl->appendTemplate('CreateNote');
$tpl->appendTemplate('MainPageFooter');
$tpl->display();
?>