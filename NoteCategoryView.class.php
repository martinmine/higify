<?php
require_once('Template/WebPageElement.class.php');
require_once('Template/Template.class.php');
require_once('Schedule/ScheduleController.class.php');
require_once('SessionController.class.php');

class NoteCategoryView extends WebPageElement
{
    private $scheduleItems;
    
    public function __construct()
    {
        $userID = SessionController::requestLoggedinID();
        $this->scheduleItems = ScheduleController::getCourseElements($userID);
        $this->scheduleItems['default'] = 'Other';
    }

    public function generateHTML()
    {
        foreach ($this->scheduleItems as $code => $desc)
        {
            $tpl = new Template();
            $tpl->appendTemplate('NoteCategoryItem');
            $tpl->setValue('ITEM_LINKID', urlencode($desc));
            $tpl->setValue('ITEM_NAME', $desc);
            $tpl->display();
        }
    }
}

?>