<?php
require_once('Template/WebPageElement.class.php');
require_once('ScheduleObjectContainerElement.class.php');

class ScheduleDayContainerElement extends WebPageElement
{
    private $elements;
    private $dayBegin;
    private $dayEnd;
    private $hourBegin;
    private $hourEnd;
    
    public function __construct($elements, $dayBegin, $dayEnd, $hourBegin, $hourEnd)
    {
        $this->elements = $elements;
        $this->dayBegin = $dayBegin;
        $this->dayEnd = $dayEnd;
        $this->hourBegin = $hourBegin;
        $this->hourEnd = $hourEnd;
    }
    
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