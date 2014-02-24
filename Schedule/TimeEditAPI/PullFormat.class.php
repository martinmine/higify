<?php
/**
 * Enum which tells the TimeEditModel which file format to request
 * from the TimeEdit server
 */
class PullFormat
{
	/**
	 * Will request CSV format
	 */
	const CSV = 'csv';

	/**
	 * Will request ICS format (iCal)
	 */
	const ICS = 'ics';

	/**
	 * Will request JSON format (Search only)
	 */
	const JSON = 'json';
}
?>