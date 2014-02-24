<?php
require_once('Template/WebPageElement.class.php');
require_once('Schedule/ScheduleObject.class.php');
require_once('Schedule/ScheduleLane.class.php');

class ScheduleObjectElement extends WebPageElement
{
    private $scheduleObjects;
    
    public function __construct(ScheduleLane $objects)
    {
        $this->scheduleObjects = $objects;
    }
    
    public function generateHTML()
    {
        foreach ($this->scheduleObjects->getLane() as $obj)
        {
            $tpl = new Template();
            $tpl->appendTemplate('TimeObject');
            $tpl->setValue('ID', $obj->getID());
            $tpl->setValue('STYLE', 'blueTimeObject');
            $tpl->setValue('TITLE', $obj->getTitle());
            $tpl->setValue('ROOM', $obj->getLocation());
            $tpl->setValue('START', $obj->getStart()->format('H:i')); // hi o/
            $tpl->setValue('END', $obj->getEnd()->format('H:i'));
            $tpl->display();
        }
    }
}