<?php
require_once('ITimeTableView.interface.php');

/**
 * Describes how a TimeTable shall be displayed as a DOMDocument
 */
class DOMDocumentView implements ITimeTableView
{
	/**
	 * Creates a new element with a given name and content
	 * @param  DOMDocument $document    The root DOMDocument
	 * @param  string      $elementName Name of the new element
	 * @param  string      $text        Content of the new node
	 * @return DOMElement               The new element
	 */
	private static function createElementWithText($document, $elementName, $text)
	{
		$element = $document->createElement($elementName);
		$textNode = $document->createTextNode($text);
		$element->appendChild($textNode);
		
		return $element;
	}
	
	/**
	 * Puts all the data from the TimeTable into a DOMDocument
	 * @param  TimeTable   $table The table to put into the DOMDocument
	 * @return DOMDocument        The TimeTable as a DOMDOcument
	 */
	public function render($table)
	{
		$doc = new DOMDocument();
		$timeSchedule = $doc->createElement('TimeSchedule');
		
		$iterator = $table->getIterator();
		
		foreach ($iterator as $timeObject)
		{
			$timeElement = $doc->createElement('Event');
			
			$timeBeginFormated = $timeObject->getTimeStartFormated();
			$timeEndFormated = $timeObject->getTimeStartFormated();
			$lastChangedFormated = $timeObject->getLastChangedFormated();
			
			$id = DOMDocumentView::createElementWithText($doc, 'ID', $timeObject->getID());
			$timeBeginElement = DOMDocumentView::createElementWithText($doc, 'BeginTime', $timeBeginFormated);
			$timeEndElement = DOMDocumentView::createElementWithText($doc, 'EndTime', $timeEndFormated);
			$lastChangedElement = DOMDocumentView::createElementWithText($doc, 'LastChanged', $lastChangedFormated);
			
			$location = $timeObject->getRoom();
			$locationElement = DOMDocumentView::createElementWithText($doc, 'Location', $location);
			
			$attendanceElement = $doc->createElement('Attendance');
			
			if (is_array($timeObject->getClasses()))
			{
				foreach ($timeObject->getClasses() as $attending) 
				{
					$attendingElement = DOMDocumentView::createElementWithText($doc, 'Attending', $attending);
					$attendanceElement->appendChild($attendingElement);
				}
			}
			
			$lecturerElement = $doc->createElement('Lecturer');
			if (is_array($timeObject->getLecturer()))
			{
				foreach ($timeObject->getLecturer() as $lecturer) 
				{
					$nameElement = DOMDocumentView::createElementWithText($doc, 'Name', $lecturer);
					$lecturerElement->appendChild($nameElement );
				}
			}
			else if (strlen($timeObject->getLecturer()) > 0)
			{
				$nameElement = DOMDocumentView::createElementWithText($doc, 'Name', $timeObject->getLecturer());
				$lecturerElement->appendChild($nameElement);
			}
			
			$courseCodesElement = $doc->createElement('CourseCode');
			
			$courseData = $timeObject->getCourseCodes();
			foreach ($courseData as $courseCode)
			{
				$courseInfo = $doc->createElement('Course');
				if (is_string($courseCode) == false)
				{
					foreach ($courseCode as $code => $desc)
					{
						$codeElement = DOMDocumentView::createElementWithText($doc, 'Code', $code);
						$descElement = DOMDocumentView::createElementWithText($doc, 'Description', $desc);
						
						$courseInfo->appendChild($codeElement);
						$courseInfo->appendChild($descElement);
					}
				}
				else
				{
					$codeElement = DOMDocumentView::createElementWithText($doc, 'Code', $courseCode);
					$courseInfo->appendChild($codeElement);
				}
				$courseCodesElement->appendChild($courseInfo);
			}
			
			$timeElement->appendChild($id);
			$timeElement->appendChild($timeBeginElement);
			$timeElement->appendChild($timeEndElement);
			$timeElement->appendChild($lastChangedElement);
			$timeElement->appendChild($locationElement);
			$timeElement->appendChild($attendanceElement);
			$timeElement->appendChild($lecturerElement);
			$timeElement->appendChild($courseCodesElement);
			
			$timeSchedule->appendChild($timeElement);
		}
		
		$doc->appendChild($timeSchedule);
		return $doc;
	}
}
?>