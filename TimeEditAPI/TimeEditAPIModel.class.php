<?php

require_once('TableObject.class.php');
require_once('TimeTable.class.php');

class TimeEditAPIModel
{
	protected $queryURL;
	
	const TIME_ZONE = 'UTC+1';
	const LINE_NUM = 4; // The line number we can find the table defintions on in CSV files

	function __construct($queryURL)
	{
		$this->queryURL = $queryURL;
	}
	
	protected function pullResponse($format)
	{
		return file_get_contents(sprintf($this->queryURL, $format));
	}

	protected function parseCSVRow($line)
	{
        $csvRowElements = str_getcsv($line);
		$rowElements = array();

		foreach ($csvRowElements as $rowElement)
		{
            $rowElement = trim($rowElement);
            if (strpos($rowElement, ', ') !== FALSE)
            {
                $rowElement = explode(', ', $rowElement);
            }
            
            $rowElements[] = $rowElement;
		}
        
		return $rowElements;
	}

	protected function hasDefinitions(&$value)
	{
		return ($value[0] == '"' && $value[strlen($value) - 1] == '"');
	}

	public function parseCSV(&$table)
	{
		$response = TimeEditAPIModel::pullResponse('csv');
		$lines = explode("\n", $response);
		$lineCount = count($lines);
		// Could have been made better by "searching" for a row with a matching amount of ',' 
		// according to the following rows, requires more resources and therefore I have chosen to use a constant instead
		$rowDefinitions = TimeEditAPIModel::parseCSVRow($lines[TimeEditAPIModel::LINE_NUM - 1]);	

		for ($i = TimeEditAPIModel::LINE_NUM; $i < $lineCount; $i++)
		{
			if (strlen($lines[$i]) == 0)	// Yes, I know this is bad, but we want to skip if it is an empty line
				continue;

            $rowItems = TimeEditAPIModel::parseCSVRow($lines[$i]);
            $lineValueCount = count($rowItems);
            $tableObject = new TableObject();
            
            for ($j = 0; $j < $lineValueCount; $j++)
            {
                $item = $rowItems[$j];
                if (isset($rowDefinitions[$j][0]) && $rowDefinitions[$j][0] == 'Emne')
                {
					$subjects = array();
					$valueCount = count($item);
					$k = 0;
					
					while ($k < $valueCount)
					{
						$subjects[] = array($item[$k++] => $item[$k++]);
					}
					
					$tableObject->setCourseCodes($subjects);
					
                }
                else
                {
					switch ($rowDefinitions[$j]) 
					{
						case 'Begin date':
							{
								if (isset($timeBegin))
								{
									throw new Exception('Date begin has to come before begin time: line ' . $i . ' column ' . $j);
								}

								$timeBegin = $item;
								break;
							}

						case 'Begin time':
							{
								if (!isset($timeBegin))
								{
									throw new Exception('Begin date has to come before begin time: line ' . $i . ' column ' . $j);
								}

								$tableObject->setTimeStart(TimeEditAPIModel::parseCSVDateTime($timeBegin . ' ' . $item));
								
								
								unset($timeBegin);
								
								break;
							}

						case 'End date':
							{
								if (isset($endTime))
								{
									throw new Exception('Missing end time before line ' . $i . ' column ' . $j);
								}

								$endTime = $item;
								break;
							}

						case 'End time':
							{
								if (!isset($endTime))
								{
									throw new Exception('Missing end date, has to come before end time, line ' . $i . ' column ' . $j);
								}

								$tableObject->setTimeEnd(TimeEditAPIModel::parseCSVDateTime($endTime . ' ' . $item));
								unset($endTime);
								break;
							}

						case 'Rom':
							{
								$tableObject->setRoom($item);
								break;
							}

						case 'Ansatte':
							{
								$tableObject->setLecturer($item);
								break;
							}

						case 'Kull':
							{
								$tableObject->setClasses($item);
							}
						
						case '':
						case 'info':	// Ignore
							{
								break;
							}
						default:
							{
								trigger_error('Column ' . $j . '=>' . $rowDefinitions[$j] . ' is unknown');
								break;
							}
					}
                }
            }
			
			$table->addObject($tableObject);
		}
	}	

	public function parseICS(&$table)
	{
		$response = TimeEditAPIModel::pullResponse('ics');
		$lines = explode("\n", $response);
		$lineCount = count($lines);
		$currentObject;

		for ($i = 0; $i < $lineCount; $i++)
		{
			$args = explode(':', $lines[$i]);
			switch (trim($args[0])) 
			{
				case 'BEGIN':
					$currentObject = new TableObject();
					break;

				case 'DTSTART':
				
					$currentObject->setTimeStart(TimeEditAPIModel::parseICSDateTime(trim($args[1])));
					break;

				case 'DTEND':
					$currentObject->setTimeEnd(TimeEditAPIModel::parseICSDateTime(trim($args[1])));
					break;

				case 'LAST-MODIFIED':
					$currentObject->setLastChanged(TimeEditAPIModel::parseICSDateTime(trim($args[1])));
					break;

				case 'SUMMARY':
					$currentObject->setCourseCodes(array(trim($args[1])));
					break;

				case 'LOCATION':
					$currentObject->setRoom(trim($args[1]));
					break;

				case 'DESCRIPTION':
					$currentObject->setID(str_replace('ID ', '', trim($args[1])));
					break;

				case 'END':
					if (trim($args[1]) == 'VEVENT')
					{
						$objectID = $currentObject->getID();
						$table->addObjectWithID($currentObject, $objectID);
						unset($currentObject);
					}
					break;

				case 'VERSION':
				case 'METHOD':
				case 'X-WR-CALNAME':
				case 'CALSCALE':
				case 'PRODID':
				case 'UID':
				case 'DTSTAMP':
				case '': // ICS always ends with an empty line
					break;
					
				default:
					trigger_error($args[0] . ' is an known ICS entry');
					break;
			}	
		}
	}
	
	// Associated = ICS, indexed = CVS
	protected function mergeTables(&$associatedTable, &$indexedTable)
	{
		$keyContainer = $associatedTable->getTableKeys();
		$keyCount = count($keyContainer);

		for ($i = 0; $i < $keyContainer; $i++)
		{
			
			$itemID = $keyContainer[$i];	// Time Object ID, can be used as key in associatedTable
			$CSVElement = NULL;
			$ICSElement = $associatedTable->getItem($itemID);
			
			$padding = $i;
			
			do
			{
				$CSVElement = $indexedTable->getItem($padding++);
			}
			while (!$CSVElement->match($ICSElement) && $padding < $keyCount);
			
			if ($CSVElement !== NULL)
			{
				$ICSElement->setCourseCodes($CSVElement->getCourseCodes());
				$ICSElement->setLecturer($CSVElement->getLecturer());
				$ICSElement->setClasses($CSVElement->getClasses());
			}
			/*
			Lecturer
			Classes
			
			ICS:
			Har ID
			Mangler fagkoder etc
			CSV:
			
			CSV => ICS
			
			
			*/
			
			print_r($CSVElement);
			echo "<br>";
			print_r($ICSElement);
			die();
			
		}
	}
	
	protected function parseCSVDateTime($time)
	{
		return DateTime::createFromFormat('Y-m-d h:i', $time, new DateTimeZone('Europe/Berlin'));
	}
	
	protected function parseICSDateTime($time)
	{
		return DateTime::createFromFormat('Ymd?His?', $time, new DateTimeZone('UTC'));
	}

	public function fillMissingData($type, &$table)
	{
		$tableDiff = new TimeTable();
		if ($type == 'ICS')
		{
			TimeEditAPIModel::parseCSV($tableDiff);
			TimeEditAPIModel::mergeTables($table, $tableDiff);
		}
		else
		{
			TimeEditAPIModel::parseICS($tableDiff);
			
		}
		
	}
}

?>