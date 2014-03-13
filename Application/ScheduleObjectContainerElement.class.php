<?php
require_once('Template/WebPageElement.class.php');
require_once('ScheduleObjectElement.class.php');

/**
 * Container for the one-hour in the schedule
 */
class ScheduleObjectContainerElement extends WebPageElement
{
    /**
     * All the schedule objects for this span
     * @var Array
     */
    private $scheduleObjects;
    
    /**
     * The first hour of the time span in the schedule
     * @var integer
     */
    private $hourBegin;
    
    /**
     * The last hour of the time span in the schedule
     * @var integer
     */
    private $hourEnd;
    
    public function __construct($obj, $hourBegin, $hourEnd)
    {
        $this->scheduleObjects = $obj;   
        $this->hourBegin = $hourBegin;
        $this->hourEnd = $hourEnd;
    }
    
    /**
     * Creates the time cell and fills it with its contents
     */
    public function generateHTML()
    {
        for ($i = $this->hourBegin; $i < $this->hourEnd; $i++)
        {
            $tpl = new Template();
            $tpl->appendTemplate('ScheduleCell');
            
            if (isset($this->scheduleObjects[$i])) // If there is anything for this hour
                $tpl->setValue('OBJ', new ScheduleObjectElement($this->scheduleObjects[$i]));
            else
                $tpl->setValue('OBJ', '');     // Show empty
            
            $tpl->display();
        }
    }
}

?>