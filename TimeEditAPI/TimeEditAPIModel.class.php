<?php

require_once('TableObject.class.php');
require_once('TimeTable.class.php');

class TimeEditAPIModel
{
	protected $queryURL;

	const LINE_NUM = 5; // The line number we can find the table defintions on in CSV files

	function __construct($queryURL)
	{
		$this->queryURL = $queryURL;
	}

	protected function pullResponse()
	{
		return file_get_contents($this->queryURL);
	}

	protected function getRowDefinitions($line)
	{
		$allRowDefinitions = explode(', ', $line);		// Line of table definitions is on line 4 (- 1)
		$parsedRowDefitinions = array();				// Paresed result from rowDefinitions

		foreach ($allRowDefinitions as $rowDefinition)
		{
			$rowDefinition = trim($rowDefinition);		// Remove whitespaces on front/beginning
			$rowStrlen = strlen($rowDefinition);

			if ($rowStrlen > 1)
			{
				if (TimeEditAPIModel::hasDefinitions($rowDefinition))
				{
					$rowDefinition = substr($rowDefinition, 1, $rowStrlen - 1);		// Remove the " on both ends of the string
					$parsedRowDefitinions[] = explode(', ', $rowDefinition);		// Then split the data and add to rowdefs
				}
				else
				{
					$parsedRowDefitinions[] = $rowDefinition;
				}
			}
		}
        
        foreach ($parsedRowDefitinions as $t)
        {
            echo $t . '</br>';
        }
        exit;
		return $parsedRowDefitinions;
	}

	protected function hasDefinitions(& $value)
	{
		return ($value[0] == '"' && $value[strlen($value) - 1] == '"');
	}

	public function parseCSV(& $tale)
	{
		$response = TimeEditAPIModel::pullResponse();
		$lines = explode("\n", $response);
		$lineCount = count($lines);
		// Could have been made better by "searching" for a row with a matching amount of ',' 
		// according to the following rows, requires more resources and therefore I have chosen to use a constant instead
		$rowDefinitions = TimeEditAPIModel::getRowDefinitions($lines[TimeEditAPIModel::LINE_NUM - 1]);	

		for ($i = TimeEditAPIModel::LINE_NUM; $i < $lineCount; $i++)
		{
			if (strlen($lines[$i]) == 0)	// Yes, I know this is bad, but we want to skip if it is an empty line
				continue;

			$lineValues = explode(', ', $lines[$i]);	// Every line
			$lineValueCount = count($lineValues);
			$tableObject = new TableObject();

			for ($j = 0; $j < $lineValueCount; $j++)	// Every value in the line
			{
				$value = trim($lineValues[$j]);

				if (TimeEditAPIModel::hasDefinitions($value) && $rowDefinitions[$j][0] == 'Emne')	// Is room
				{
					$values = explode(', ', substr($value, 1, strlen($value) - 1));	// Split value
					$valueCount = count($rowDefinitions[$j]);

					if ($valueCount == 2) // Is subject
					{
						$k = 0;
						$subjects = array();
						
						// Every subject is like courseCode => course description, courseCode => courseDescription ...
						while ($k > $valueCount)
						{
							$subjects[] = array($values[$k++] => $values[$k++]);
						}

						$tableObject->setCourseCodes($subjects);
					}
					else
					{
						trigger_error('Unknown row definition for line ' . $i . ' column ' . $j);
					}
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

							$timeBegin = $value;
							break;
						}

						case 'Begin time':
						{
							if (!isset($timeBegin))
							{
								throw new Exception('Begin date has to come before begin time: line ' . $i . ' column ' . $j);
							}

							$tableObject->setTimeStart(date_parse($timeBegin . ' ' . $value));
							unset($timeBegin);

							break;
						}

						case 'End date':
						{
							if (isset($endTime))
							{
								throw new Exception('Missing end time before line ' . $i . ' column ' . $j);
							}

							$endTime = $value;
							break;
						}

						case 'End time':
						{
							if (!isset($endTime))
							{
								throw new Exception('Missing end date, has to come before end time, line ' . $i . ' column ' . $j);
							}

							$tableObject->setTimeEnd(date_parse($endTime . ' ' . $value));
							unset($endTime);
							break;
						}

						case 'Rom':
						{
							$tableObject->setRoom($value);
							break;
						}

						case 'Ansatte':
						{
							$tableObject->setLecturer($value);
							break;
						}

						case 'Kull':
						{
							$tableObject->setClasses(explode(', ', $value));
						}
						
						case 'info':	// Ignore
						{
							break;
						}
						default:
						{
							trigger_error('Column ' . $j . '=>' . $rowDefinitions[$j] . ' is unknown');
							// Show warning?
							break;
						}
					}
				}
			}

			$table->addObject($tableObject);
		}
	}	

	public function parseICS(& $table)
	{
		$response = TimeEditAPIModel::pullResponse();
		$lines = explode("\n", $response);
		$lineCount = count($lines);
		$currentObject;

		for ($i = 0; $i < $lineCount; $i++)
		{
			$args = explode(':', $lines[$i]);
			switch ($args[0]) 
			{
				case 'BEGIN':
					$currentObject = new TableObject();
					break;

				case 'DTSTART':
					$currentObject->setTimeStart(date_parse($args[1]));
					break;

				case 'DTEND':
					$currentObject->setTimeEnd(date_parse($args[1]));
					break;

				case 'LAST-MODIFIED':
					$currentObject->setLastChanged(date_parse($args[1]));
					break;

				case 'SUMMARY':
					$currentObject->setCourseCodes(array($args[1]));
					break;

				case 'LOCATION':
					$currentObject->setRooms(array($args[1]));
					break;

				case 'DESCRIPTION':
					$currentObject->setID(str_replace('ID ', '', $arg[1]));
					break;

				case 'END':
					$table->addObjectWithID($currentObject, $currentObject->getID());
					unset($currentObject);
					break;

				default:
					trigger_error($args[0] . ' is an known ICS entry');
					break;
			}	
		}
	}

	public function fillMissingData($type, &$table)
	{

	}

}

?>