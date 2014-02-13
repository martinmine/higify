<?php
/**
 * Describes which functions a TimeTable view must implement, 
 * used when the TimeTable shall be formated to the user
 */
interface ITimeTableView
{
	public function render($timeTable);
}
?>