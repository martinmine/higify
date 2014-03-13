<?php
require_once('Template/WebPageElement.class.php');
require_once('Template/Template.class.php');

class EmptyScheduleView extends WebPageElement
{
    public function generateHTML()
    {
        $tpl = new Template();
        $tpl->appendTemplate('EmptyScheduleMessage');
        $tpl->display();
    }
}
?>