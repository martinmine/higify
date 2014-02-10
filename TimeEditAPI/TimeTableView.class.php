<?php
require_once('ITimeTableView.interface.php');

class TimeTableView implements ITimeTableView
{
	/**
	 * Returns how the TimeTable shall be represented externally
	 * @param  TimeTable $table TimeTable to view as TimeTable
	 * @return TimeTable        The TimeTable
	 */
	public function render($timeTable)
	{
		return $timeTable;
	}
}
?>