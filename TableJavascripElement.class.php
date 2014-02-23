<?php
require_once('Template/WebPageElement.class.php');
require_once('Schedule/ScheduleLane.class.php');
require_once('Schedule/ScheduleObject.class.php');

class TableJavascriptElement extends WebPageElement
{
    private $elements;
    
    public function __construct($elements)
    {
        $this->elements = $elements;   
    }
    
    public function generateHTML()
    {
        foreach ($this->elements as $lane)
        {
            foreach ($lane->getLane() as $obj)
            {
                $tpl = new Template();
                $tpl->appendTemplate('TimeObjectJavaScript');
                $tpl->setValue('ID', $obj->getID());
                $tpl->setValue('MINUTE', $obj->getStart()->format('H'));
                $tpl->setValue('DURATION', 10); //TODO
                $tpl->display();
            }
        }
    }
}

?>