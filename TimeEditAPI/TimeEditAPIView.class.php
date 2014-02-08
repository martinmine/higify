<?php

require_once('OutputType.class.php');
require_once('TimeTable.class.php');
require_once('TableObject.class.php');

class TimeEditAPIView
{
	/**
	 * Creates a JSON presentation of the TimeTable
	 * @param  TimeTable $table TimeTable to view as JSON
	 * @return string           The TimeTable as JSON text in a string
	 */
	private static function getJSON($table)
	{
		return json_encode($table);
	}
	
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
    private static function getDOMDocument($table)
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
			
			$id = TimeEditAPIView::createElementWithText($doc, 'ID', $timeObject->getID());
			$timeBeginElement = TimeEditAPIView::createElementWithText($doc, 'BeginTime', $timeBeginFormated);
			$timeEndElement = TimeEditAPIView::createElementWithText($doc, 'EndTime', $timeEndFormated);
			$lastChangedElement = TimeEditAPIView::createElementWithText($doc, 'LastChanged', $lastChangedFormated);
			
			$location = $timeObject->getRoom();
			$locationElement = TimeEditAPIView::createElementWithText($doc, 'Location', $location);
			
			$attendanceElement = $doc->createElement('Attendance');
			
			if (is_array($timeObject->getClasses()))
			{
				foreach ($timeObject->getClasses() as $attending) 
				{
					$attendingElement = TimeEditAPIView::createElementWithText($doc, 'Attending', $attending);
					$attendanceElement->appendChild($attendingElement);
				}
			}
			
			$lecturerElement = $doc->createElement('Lecturer');
			if (is_array($timeObject->getLecturer()))
			{
				foreach ($timeObject->getLecturer() as $lecturer) 
				{
					$nameElement = TimeEditAPIView::createElementWithText($doc, 'Name', $lecturer);
					$lecturerElement->appendChild($nameElement );
				}
			}
			else if (strlen($timeObject->getLecturer()) > 0)
			{
				$nameElement = TimeEditAPIView::createElementWithText($doc, 'Name', $timeObject->getLecturer());
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
						$codeElement = TimeEditAPIView::createElementWithText($doc, 'Code', $code);
						$descElement = TimeEditAPIView::createElementWithText($doc, 'Description', $desc);
						
						$courseInfo->appendChild($codeElement);
						$courseInfo->appendChild($descElement);
					}
				}
				else
				{
					$codeElement = TimeEditAPIView::createElementWithText($doc, 'Code', $courseCode);
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
	
	/**
	 * Gets the XML data for the TimeTable
	 * @param  TimeTable $table The TimeTable we want as XML data
	 * @return string           The XML data
	 */
	private static function getXML($table)
	{
		return TimeEditAPIView::getDOMDocument($table)->saveXML();
	}
    
    /**
     * Creates a view and returns it according to the output format
     * @param  TimeTable             $timeTable    The source time table we want to view
     * @param  OutputType            $outputFormat The output type the user wants returned
     * @return string or DOMDOcument               Depends on the OutputType
     */
    public static function render($timeTable, $outputFormat)
	{
        switch ($outputFormat)
        {
            case OutputType::XMLDocument: 
                {
                    return TimeEditAPIView::getXML($timeTable);
                }
            case OutputType::JSON:
                {
                    return TimeEditAPIView::getJSON($timeTable);
                }
            case OutputType::DOMDocument:
                {
                    return TimeEditAPIView::getDOMDocument($timeTable);
                }
            case OutputType::TimeTable:
                {
                    return $timeTable;
                }
        }
	}
}
?>