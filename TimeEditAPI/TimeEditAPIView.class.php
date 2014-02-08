<?php

require_once('OutputType.class.php');
require_once('TimeTable.class.php');
require_once('TableObject.class.php');

class TimeEditAPIView
{
	private static function getJSON($table)
	{
		return json_encode($table);
	}
	
	private static function createElementWithText($document, $elementName, $text)
	{
		$element = $document->createElement($elementName);
		$textNode = $document->createTextNode($text);
		$element->appendChild($textNode);
		
		return $element;
	}

	private static function appendAttribute($document, $mother, $name, $value)
	{
		$attribute = $document->createAttribute($name);
		$attribute->value = $value;
		$mother->appendChild($attribute);
	}	

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
	
	private static function getXML($table)
	{
		return TimeEditAPIView::getDOMDocument($table)->saveXML();
	}
    
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