<?php
/**
 * Enum specifying what type shall be returned to the user through the view
 */
class OutputType
{
	/**
	 * Will return a TimeTable object
	 */
	const TIME_TABLE = 0;

	/**
	 * Will return a DOMDocument object
	 */
	const DOM_DOCUMENT = 1;

	/**
	 * Will return a XMLObject as a string
	 */
	const XML_DOCUMENT = 2;

	/**
	 * Will return a JSON object as a string
	 */
	const JSON = 3;
}
?>