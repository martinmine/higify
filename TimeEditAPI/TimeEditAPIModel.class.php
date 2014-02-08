<?php
require_once('TableObject.class.php');
require_once('TimeTable.class.php');
require_once('PullFormat.class.php');

class TimeEditAPIModel
{
	protected $queryURL;
	
	const CSV_TIME_ZONE = 'Europe/Berlin';
	const ICS_TIME_ZONE = 'UTC';
	
	
	const CSV_LINE_NUM = 4; // The line number we can find the table defintions on in CSV files

	function __construct($queryURL)
	{
		$this->queryURL = $queryURL;
	}
	
	protected function pullResponse($format)
	{
		return file_get_contents(sprintf($this->queryURL, $format));
	}

	protected function parseCSVDateTime($time)
	{
		return DateTime::createFromFormat('Y-m-d H:i', $time, new DateTimeZone(TimeEditAPIModel::CSV_TIME_ZONE));
	}
	
	protected function parseICSDateTime($time)
	{
		return DateTime::createFromFormat('Ymd?His?', $time, new DateTimeZone(TimeEditAPIModel::ICS_TIME_ZONE));
	}
	
	protected function parseCSVRow($line)
	{
        $csvRowElements = str_getcsv($line);
		$rowElements = array();

		foreach ($csvRowElements as $rowElement)
		{
            $rowElement = trim($rowElement);
            if (strpos($rowElement, ', ') !== FALSE)
                $rowElement = explode(', ', $rowElement);
            
            $rowElements[] = $rowElement;
		}
        
		return $rowElements;
	}

	public function parseCSV(&$table)
	{
		$response = TimeEditAPIModel::pullResponse(PullFormat::CSV);
		$lines = explode("\n", $response);
		$lineCount = count($lines);
		$rowDefinitions = TimeEditAPIModel::parseCSVRow($lines[TimeEditAPIModel::CSV_LINE_NUM - 1]);	

		for ($i = TimeEditAPIModel::CSV_LINE_NUM; $i < $lineCount; $i++)
		{
			if (strlen($lines[$i]) == 0)	// Yes, I know this is bad (For the sake of indent)
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
						$subjects[] = array($item[$k++] => $item[$k++]);
					
					$tableObject->setCourseCodes($subjects);
                }
                else
                {
					switch ($rowDefinitions[$j]) 
					{
						case 'Begin date':
							{
								if (isset($timeBegin))
									throw new Exception('Date begin has to come before begin time: line ' . $i . ' column ' . $j);

								$timeBegin = $item;
								break;
							}

						case 'Begin time':
							{
								if (!isset($timeBegin))
									throw new Exception('Begin date has to come before begin time: line ' . $i . ' column ' . $j);

								$tableObject->setTimeStart(TimeEditAPIModel::parseCSVDateTime($timeBegin . ' ' . $item));
								unset($timeBegin);
								break;
							}

						case 'End date':
							{
								if (isset($endTime))
									throw new Exception('Missing end time before line ' . $i . ' column ' . $j);

								$endTime = $item;
								break;
							}

						case 'End time':
							{
								if (!isset($endTime))
									throw new Exception('Missing end date, has to come before end time, line ' . $i . ' column ' . $j);

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
						case 'info':	// Ignore this element
							{
								break;
							}
							
						default:		// Unknown element
							{
								trigger_error('Column ' . $j . '=>' . $rowDefinitions[$j] . ' is unknown');
								break;
							}
					}
                }
            }
			
			$table->addObject($tableObject);	// We are done adding data to this object, add it to the table
		}
	}	

	public function parseICS(&$table)
	{
		$response = TimeEditAPIModel::pullResponse(PullFormat::ICS);
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
					$currentObject->setCourseCodes(explode('\\, ', trim($args[1])));
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
	protected function mergeTables(&$source, &$destination)
	{
		$keyContainer = $destination->getTableKeys();
		$keyCount = count($keyContainer);
		for ($i = 0; $i < $keyCount; $i++)
		{
			$srcElement = NULL;
			$dstElement = $destination->getItem($keyContainer[$i]); // Get item number i from destination table
			$padding = $i;		// At which item in the source array to compare dstElement with
			
			do
			{
				$srcElement = $source->getItem($padding++);						// Get the next element from table
			}
			while (!$srcElement->match($dstElement) && $padding < $keyCount);	// While no match found and within array bounds
			
			if ($srcElement != NULL && $srcElement->match($dstElement))			// If a match was found, set data
			{
				$dstElement->setCourseCodes($srcElement->getCourseCodes());
				$dstElement->setLecturer($srcElement->getLecturer());
				$dstElement->setClasses($srcElement->getClasses());
			}
		}
	}

	public function fillMissingData($tableType, &$table)
	{
		$tableDiff = new TimeTable();
		if ($tableType == PullFormat::ICS)
		{
			TimeEditAPIModel::parseCSV($tableDiff);
			TimeEditAPIModel::mergeTables($tableDiff, $table);
			return $table;
		}
		else
		{
			TimeEditAPIModel::parseICS($tableDiff);
			TimeEditAPIModel::mergeTables($table, $tableDiff);
			return $tableDiff;
		}
	}
}

?>