<?php
require_once('ITimeTableView.interface.php');
require_once('TimeTableViewFactory.class.php');
require_once('OutputType.class.php');

class XMLDocumentView implements ITimeTableView
{
	public function render($timeTable)
	{
		$domView = TimeTableViewFactory::getView(OutputType::DOM_DOCUMENT);
		$domDocument = $domView->render($timeTable);
		return $domDocument->saveXML();
	}
}
?>