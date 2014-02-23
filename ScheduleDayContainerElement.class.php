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
        //$this->elements = new ScheduleObjectContainerElement($elements, $hourBegin, $hourEnd);
        $this->elements = $elements;
        $this->dayBegin = $dayBegin;
        $this->dayEnd = $dayEnd;
        $this->hourBegin = $hourBegin;
        $this->hourEnd = $hourEnd;
    }
    
    public function generateHTML()
    {
        for ($i = $this->dayBegin; $i <= $this->dayEnd; $i++)
        {
            $tpl = new Template('ScheduleDayContainer');
            $tpl->setValue('DAY', $this->day);
            $tpl->setValue('ELEMENTS', new ScheduleObjectContainerElement($this->elements[$i], $this->hourBegin, $this->hourEnd));
            $tpl->display();
        }
    }
}

?>