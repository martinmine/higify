<?php
require_once('Template/WebPageElement.class.php');
require_once('Schedule/ScheduleLane.class.php');
require_once('Schedule/ScheduleObject.class.php');

class TableJavascriptElement extends WebPageElement
{
    private $elements;
    private $dayBegin;
    private $dayEnd;
    
    public function __construct($elements, $dayBegin, $dayEnd)
    {
        $this->elements = $elements;   
        $this->dayBegin = $dayBegin;
        $this->dayEnd = $dayEnd;
    }
    
    public function generateHTML()
    {
        for ($i = $this->dayBegin; $i <= $this->dayEnd; $i++)
        {
            foreach ($this->elements[$i] as $lane)
            {
                foreach ($lane->getLane() as $obj)
                {
                    $diff = $obj->getEnd()->diff($obj->getStart());
                    
                    $tpl = new Template();
                    $tpl->appendTemplate('TimeObjectJavaScript');
                    $tpl->setValue('ID', $obj->getID());
                    $tpl->setValue('MINUTE', $obj->getStart()->format('i'));
                    $tpl->setValue('DURATION', $diff->i + ($diff->h * 60));
                    $tpl->display();
                }
            }
        }
    }
}

?>