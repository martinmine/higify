<?php
require_once('Template/WebPageElement.class.php');
require_once('ScheduleObjectContainerElement.class.php');

/**
 * Generates each lane in the schedule
 */
class ScheduleDayContainerElement extends WebPageElement
{
    /**
     * All the ScheduleObjects for the lanes
     * @var Array
     */
    private $elements;
    
    /**
     * Number of the day when the schedule begins
     * @var integer
     */
    private $dayBegin;
    
    /**
     * Number of the day when the schedule ends
     * @var integer
     */
    private $dayEnd;
    
    /**
     * Number of the first hour to display in the schedule
     * @var mixed
     */
    private $hourBegin;
    
    /**
     * Number of the last hour to display in the schedule
     * @var mixed
     */
    private $hourEnd;
    
    public function __construct($elements, $dayBegin, $dayEnd, $hourBegin, $hourEnd)
    {
        $this->elements = $elements;
        $this->dayBegin = $dayBegin;
        $this->dayEnd = $dayEnd;
        $this->hourBegin = $hourBegin;
        $this->hourEnd = $hourEnd;
    }
    
    /**
     * Prints the lanes for each day in the schedule
     */
    public function generateHTML()
    {
        $days = array(1 => 'Monday',
                      2 => 'Tuesday',
                      3 => 'Wednesday',
                      4 => 'Thursday',
                      5 => 'Friday',
                      6 => 'Saturday',
                      7 => 'Sunday');

        
        for ($i = $this->dayBegin; $i <= $this->dayEnd; $i++)
        {
            $tpl = new Template();
            $tpl->appendTemplate('ScheduleDayContainer');
            $tpl->setValue('DAY', $days[$i]);
            $tpl->setValue('ELEMENTS', new ScheduleObjectContainerElement(isset($this->elements[$i]) ? $this->elements[$i] : NULL, $this->hourBegin, $this->hourEnd));
            $tpl->display();
        }
    }
}

?>