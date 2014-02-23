<?php
require_once('Template/WebPageElement.class.php');
require_once('Template/Template.class.php');

class TimeLabelElement extends WebPageElement
{
    private $hourBegin;
    private $hourEnd;
    
    public function __construct($hourBegin, $hourEnd)
    {
        $this->hourBegin = $hourBegin;
        $this->hourEnd = $hourEnd;
    }
    
    public function generateHTML()
    {
        for ($i = $this->hourBegin + 1; $i <= $this->hourEnd; $i++)
        {
            $tpl = new Template();
            $tpl->appendTemplate('ScheduleTimeElement');
            $tpl->setValue('HOUR', $i);
            $tpl->display();
        }
    }
}
?>