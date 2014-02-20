<?php
require_once('Template/Template.class.php');
include_once('Template/WebPageElement.class.php');


/**
 *
 *
 */
class DayScheduleView extends WebPageElement
{
	private $classHours = NULL;		//	@val class-hour object...
	
	public function __construct()
	{
		//$userID = SessionController::requestLoggedinID();
		//$this->classHours ...
	}

	public function generateHTML()
	{
		
		foreach($this->classHours as $hour)
		{
			$tpl = new Template();
			/*
			$tpl->appendTemplate('HourElement');
			$tpl->setValue('CLASS_NAME', $hour['classname']);
			$tpl->setValue('ROOM', $hour['room']);
			$tpl->setValue('START', $hour['start']);
			$tpl->setValue('END', $hour['end']);
             */
			$tpl->display();
		}
	}
}
?>