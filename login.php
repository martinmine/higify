<?php

require_once('Template/Template.class.php');

$tpl = new Template();
$tpl->appendTemplate('LoginHeader');
$tpl->appendTemplate('LoginBody');
$tpl->appendTemplate('LoginFooter');
$tpl->display();

?>