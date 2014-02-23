<?php
require_once('Template/WebPageElement.class.php');
require_once('ScheduleDayContainerElement.class.php');
require_once('TableJavascripElement.class.php');
require_once('TimeLabelElement.class.php');

class ScheduleBody extends WebPageElement
{
    private $schedule;
    private $hourBegin;
    private $hourEnd;
    
    const DAY_BEGIN = 0;
    const DAY_END = 5;
    
    const HOUR_BEGIN = 8;
    const HOUR_END = 17;
    
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
        $tpl->setValue('TABLEJS', new TableJavascripElement($this->schedule));
        $tpl->setValue('HOURBEGIN', $this->hourBegin);
        $tpl->setValue('TIMELABELS', new TimeLabelElement($hourBegin, $hourEnd));
        $tpl->setValue('DAYS', new ScheduleDayContainerElement($this->schedule, self::DAY_BEGIN, self::DAY_END, self::HOUR_BEGIN, self::HOUR_END));
        $tpl->display();
    }
}


?>