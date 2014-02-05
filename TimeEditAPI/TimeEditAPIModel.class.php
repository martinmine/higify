<?php

require_once('TableObject.class.php');

class TimeEditAPIModel
{
	protected $queryURL;

	const LINE_NUM = 4; // The line number we can find the table defintions on in CSV files

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

		foreach ($parsedRowDefitinions as $rowDefinition)
		{
			$rowDefinition = trim($rowDefinition);		// Remove whitespaces on front/beginning
			$rowStrlen = strlen($rowDefinition);

			if ($rowStrlen > 1)
			{
				if (hasDefinitions($rowDefinition))
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

		return $rowDef;
	}

	protected function hasDefinitions(& $value)
	{
		return ($value[0] == '"' && $value[strlen($value) - 1] == '"');
	}

	public function parseCSV(& $tale)
	{
		$response = pullResponse();
		$lines = explode("\n", $response);
		$lineCount = count($lines);
		// Could have been made better by "searching" for a row with a matching amount of ',' 
		// according to the following rows, requires more resources and therefore I have chosen to use a constant instead
		$rowDefinitions = TimeEditAPIView::getRowDefinitions($lines[LINE_NUM - 1]);	

		for ($i = LINE_NUM; $i < $lineCount; $i++)
		{
			$lineValues = explode(', ', $lines[$i]);	// Every line
			$lineValueCount = count($lineValues);

			for ($j = 0; $j < $lineValueCount; $j++)	// Every value in the line
			{
				$value = trim($lineValues[$j]);
				// ...
			}
		}
	}	

	public function parseICS(& $table)
	{
		$response = pullResponse();
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
					$table->addItem($currentObject);
					break;
			}	
		}
	}

	public function fillMissingData($type, &$table)
	{

	}

}

?>