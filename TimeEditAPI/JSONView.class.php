<?php
require_once('ITimeTableView.interface.php');

class JSONView implements ITimeTableView
{
	/**
	 * Creates a JSON presentation of the TimeTable
	 * @param  TimeTable $table TimeTable to view as JSON
	 * @return string           The TimeTable as JSON text in a string
	 */
	public function render($table)
	{
		return json_encode($table);
	}
}
?>