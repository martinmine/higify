<?php
require_once('Template/Template.class.php');
require_once('Template/WebPageElement.class.php');

class StalkerListView extends WebPageElement
{
    private $stalkers;
    
    public function __construct($stalkers)
    {
        $this->stalkers = $stalkers;
    }
    
    public function generateHTML()
    {
        foreach ($this->stalkers as $stalker)
        {
            $tpl = new Template();
            $tpl->appendTemplate('StalkerElement');
            $tpl->setValue('USERID', $stalker->getUserID());
            $tpl->setValue('USERNAME', $stalker->getUsername());
            $tpl->display();
        }
    }
}
?>