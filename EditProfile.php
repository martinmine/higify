<?php
require_once('Template/Template.class.php');
require_once('editProfileController.class.php');

$tpl = new Template();
$tpl->appendTemplate('EditProfileHeader');
$tpl->setValue('PAGE_TITLE', 'Edit profile');
$tpl->registerController(new EditProfileController());
$tpl->appendTemplate('EditProfileTop');
$tpl->appendTemplate('EditProfileLeft');
$tpl->appendTemplate('EditProfileCenter');
$tpl->appendTemplate('EditProfileRight');
$tpl->appendTemplate('EditProfileFooter');
$tpl->display();
print_r($_POST);

echo "FILES:";
print_r($_FILES);

?>