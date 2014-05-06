<?php
require_once('Template/WebPageElement.class.php');
require_once('ScheduleDayContainerElement.class.php');
require_once('TableJavascriptElement.class.php');
require_once('TimeLabelElement.class.php');

class ScheduleBody extends WebPageElement
{
    /**
     * Array of all the lanes where
     * week day = lane for this day
     * @var Array
     */
    private $schedule;
    
    /**
     * The first hour in our schedule
     * @var integer
     */
    private $hourBegin;
    
    /**
     * Last hour in the schedule for the day
     * @var integer
     */
    private $hourEnd;
    
    /**
    * The week number this schedule is for
    * @var integer
    */
    private $weekNumber;
    
    /**
     * Which day number the schedule begins on (Monday = 1)
     */
    
    const DAY_BEGIN = 1;
    /**
     * Which day number the schedule ends on (Friday = 5)
     */
    const DAY_END = 5;
    
    public function __construct($schedule, $hourBegin, $hourEnd, $weekNumber)
    {
        $this->schedule = $schedule;
        $this->hourBegin = $hourBegin;
        $this->hourEnd = $hourEnd;
        $this->weekNumber = $weekNumber;
    }
    
    /**
     * The all mighty functions that prints our great schedule
     */
    public function generateHTML()
    {
        $tpl = new Template();
        $tpl->appendTemplate('ScheduleBody');
        $tpl->setValue('TABLEJS', new TableJavascriptElement($this->schedule, self::DAY_BEGIN, self::DAY_END));
        $tpl->setValue('HOURBEGIN', $this->hourBegin);
        $tpl->setValue('WEEKNUMB', $this->weekNumber);
        $tpl->setValue('TIMELABELS', new TimeLabelElement($this->hourBegin, $this->hourEnd));
        $tpl->setValue('DAYS', new ScheduleDayContainerElement($this->schedule, self::DAY_BEGIN, self::DAY_END, $this->hourBegin, $this->hourEnd));
        $tpl->display();
    }
}


?>