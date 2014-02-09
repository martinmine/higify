<?php
require_once('TableObject.class.php');
require_once('TimeTable.class.php');
require_once('PullFormat.class.php');
require_once('SearchResult.class.php');

class TimeEditAPIModel
{
	/**
	 * The base URL used for performing a lookup towards TimeEdit
	 * @var [type]
	 */
	private $queryURL;
	
	/**
	 * What time zone format is in the CSV file format from TimeEdit
	 */
	private $CSV_TIME_ZONE;

	/**
	 * What time format it is the ICS formats file format from TimeEdit
	 */
	private $ICS_TIME_ZONE;

	/**
	 * At which line number the table headers are in the CSV file
	 */
	const CSV_LINE_NUM = 4; // The line number we can find the table defintions on in CSV files

	/**
	 * Prepares a new TimeEditAPIModel
	 * @param string $queryURL The base URL used for lookup
	 */
	public function __construct($queryURL)
	{
		$this->CSV_TIME_ZONE = new DateTimeZone('Europe/Berlin'); 
		$this->ICS_TIME_ZONE = new DateTimeZone('UTC');
		$this->queryURL = $queryURL;
	}
	
	/**
	 * Pulls the server response from the base URL using cURL
	 * @param  string $format Which format to look up (JSON/ICS/CSV)
	 * @return string         The resposne from the server
	 */
	private function pullResponse($format)
	{
		$cURL = curl_init();
		
		curl_setopt($cURL, CURLOPT_HEADER, 0);
		curl_setopt($cURL, CURLOPT_VERBOSE, 1);
		curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($cURL, CURLOPT_FAILONERROR, 0);
		curl_setopt($cURL, CURLOPT_URL, sprintf($this->queryURL, $format));
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);	// For whatever reason, response got printed without this
		
		$response = curl_exec($cURL);
		curl_close($cURL);
		return $response;
	}

	/**
	 * Parses the time string formated according to the CSV_TIME_ZONE const
	 * @param  string $time   The date/time string from a CSV file
	 * @return DateTime       Parsed DateTime object
	 */
	private function parseCSVDateTime($time)
	{
		return DateTime::createFromFormat('Y-m-d H:i', $time, $this->CSV_TIME_ZONE);
	}
	
	/**
	 * Parses the time string formated according to the ICS_TIME_ZONE const
	 * @param  string   $time The the date7Time string from an ICS file
	 * @return DateTime       Parsed DateTime
	 */
	private function parseICSDateTime($time)
	{
		return DateTime::createFromFormat('Ymd?His?', $time, $this->ICS_TIME_ZONE);
	}
	
	/**
	 * Parses one CSV row from a CSV file format with the , split into arrays and the "element1, element2" are added
	 * as an array in the colum in the array
	 * @param  string $line Line to parse from the CSV file
	 * @return Array        The parsed data as an array
	 */
	private function parseCSVRow($line)
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

	/**
	 * Pulls the request form the server and parses the CSV file into the table object
	 * @param  TimeTable $table Table to parse data into
	 */
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
                if (isset($rowDefinitions[$j][0]) && $rowDefinitions[$j][0] == 'Emne')	// Parse course code data
                {
					$subjects = array();
					$valueCount = count($item);
					$k = 0;
					
					while ($k < $valueCount)
						$subjects[] = array($item[$k++] => $item[$k++]);	// Course code => Course name
					
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

	/**
	 * Pulls an ICS file from TimeEdit and parses it into a TimeTable object
	 * @param  TimeTable $table table to put data into
	 */
	public function parseICS(&$table)
	{
		$response = TimeEditAPIModel::pullResponse(PullFormat::ICS);
		$lines = explode("\n", $response);
		$lineCount = count($lines);
		$currentObject;

		for ($i = 0; $i < $lineCount; $i++)
		{
			$args = explode(':', trim($lines[$i]));
			switch ($args[0]) 
			{
				case 'BEGIN':
					$currentObject = new TableObject();
					break;

				case 'DTSTART':
				
					$currentObject->setTimeStart(TimeEditAPIModel::parseICSDateTime($args[1]));
					break;

				case 'DTEND':
					$currentObject->setTimeEnd(TimeEditAPIModel::parseICSDateTime($args[1]));
					break;

				case 'LAST-MODIFIED':
					$currentObject->setLastChanged(TimeEditAPIModel::parseICSDateTime($args[1]));
					break;

				case 'SUMMARY':
					$currentObject->setCourseCodes(explode('\\, ', $args[1]));
					break;

				case 'LOCATION':
					$currentObject->setRoom($args[1]);
					break;

				case 'DESCRIPTION':
					$currentObject->setID(str_replace('ID ', '', $args[1]));
					break;

				case 'END':
					if ($args[1] == 'VEVENT')
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
	
	/**
	 * Merges two data sets, can be described as union between two data sets
	 * @param  TimeTable $source      Where to compare the information
	 * @param  TimeTable $destination Where to update the information
	 */
	private function mergeTables(&$source, &$destination)
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

	/**
	 * Gets all the missing data which are available on the TimeEdit server
	 * but is not available in the first request sent to the server.
	 * If the first format request was an ICS request, there will be made a CSV
	 * request as the ICS doesn't contain full course data. Entered table given 
	 * to the function will be used as destination when mergin and also returned
	 * when the merging is completed.
	 * Otherwise (Not ICS at first request), an ICS request will be made 
	 * (As ICS contains all the IDs for the TableObjects), and the new 
	 * TimeTable will be returned.
	 * @param  TimeTable $tableType  TimeTable returned from the first parsing
	 * @param  PullFormat $table     What format was originally given when the 
	 *                               first request was made 
	 * @return TimeTable             TimeTable with all available data
	 */
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
	
	/**
	 * Sends a JSON request to TimeEdit with the search parameters defined
	 * by the controller and parses the result into an array of SearchResult
	 * @return Array Array containing all the SearchResult objects from JSON
	 */
	public function parseJSON()
	{
		$response = self::pullResponse(PullFormat::JSON);
		$decodedJSON = json_decode($response);
		$results = array();
		
		foreach ($decodedJSON->records as $jsonResult)
		{
			$typeID = $jsonResult->typeId;
			$id = $jsonResult->id;
			$info = '';
			$description = '';
			
			if (isset($jsonResult->fields[0]))	// If has something in fields[0]
				$info = $jsonResult->fields[0]->values[0];
			
			if (isset($jsonResult->fields[1]))	// and something in fields[1]
				$description = $jsonResult->fields[1]->values[0];
			
			if ($typeID > 0)	// TypeID = 0 is a dummy-item at the end of the JSON file
				$results[] = new SearchResult($typeID, $id, $info, $description);
		}
		
		return $results;
	}
}

?>