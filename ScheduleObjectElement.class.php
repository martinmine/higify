<?php
require_once('Template/WebPageElement.class.php');
require_once('Schedule/ScheduleObject.class.php');
require_once('Schedule/ScheduleLane.class.php');

/**
 * Informs how a ScheduleObject shall be outputted within one hour
 */
class ScheduleObjectElement extends WebPageElement
{
    /**
     * All the ScheduleObjects within this hour
     * @var Array
     */
    private $scheduleObjects;
    
    public function __construct($objects)
    {
        $this->scheduleObjects = $objects;
    }
    
    /**
     * Displays the time objects to the HTML output
     */
    public function generateHTML()
    {
        foreach ($this->scheduleObjects as $obj)
        {
            $tpl = new Template();
            $tpl->appendTemplate('TimeObject');
            $tpl->setValue('ID', $obj->getID());
            $tpl->setValue('STYLE', $obj->getStyle());
            $tpl->setValue('TITLE', $obj->getTitle());
            $tpl->setValue('ROOM', $obj->getLocation());
            $tpl->setValue('START', $obj->getStart()->format('H:i')); // hi o/
            $tpl->setValue('END', $obj->getEnd()->format('H:i'));
            $tpl->display();
        }
    }
}