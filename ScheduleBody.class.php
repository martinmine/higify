<?php
require_once('Template/WebPageElement.class.php');
require_once('ScheduleDayContainerElement.class.php');
require_once('TableJavascriptElement.class.php');
require_once('TimeLabelElement.class.php');

class ScheduleBody extends WebPageElement
{
    private $schedule;
    private $hourBegin;
    private $hourEnd;
    
    const DAY_BEGIN = 1;
    const DAY_END = 5;
    
    public function __construct($schedule, $hourBegin, $hourEnd)
    {
        $this->schedule = $schedule;
        $this->hourBegin = $hourBegin;
        $this->hourEnd = $hourEnd;
    }
    
    public function generateHTML()
    {
        $tpl = new Template();
        $tpl->appendTemplate('SchedulePrototypeBody');
        $tpl->setValue('TABLEJS', new TableJavascriptElement($this->schedule, self::DAY_BEGIN, self::DAY_END));
        $tpl->setValue('HOURBEGIN', $this->hourBegin);
        $tpl->setValue('TIMELABELS', new TimeLabelElement($this->hourBegin, $this->hourEnd));
        $tpl->setValue('DAYS', new ScheduleDayContainerElement($this->schedule, self::DAY_BEGIN, self::DAY_END, $this->hourBegin, $this->hourEnd));
        $tpl->display();
    }
}


?>