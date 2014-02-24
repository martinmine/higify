<?php
require_once('ITimeTableView.interface.php');
require_once('TimeTableViewFactory.class.php');
require_once('OutputType.class.php');

/**
 * Describes how the TimeTable shall be displayed to the user in XML form
 */
class XMLDocumentView implements ITimeTableView
{
	/**
	 * Creates XML from a TimeTable object
	 * @param TimeTable $timeTable TimeTable to be displayed as XML
	 * @return string XML data
	 */
	public function render($timeTable)
	{
		$domView = TimeTableViewFactory::getView(OutputType::DOM_DOCUMENT);
		$domDocument = $domView->render($timeTable);
		return $domDocument->saveXML();
	}
}
?>