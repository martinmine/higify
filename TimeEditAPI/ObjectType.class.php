<?php
/**
 * Enum defining available search types
 */
class ObjectType
{
	/**
	 * Is a room
	 */
	const ROOM = 185;
	
	/**
	 * Is a class code eg. 12HBPUA
	 */
	const CLASSCODE = 182;
	
	/**
	 * Is a code for one specific course (Eg. IMT1240) but can
	 * also be 'Algorithmic methods'
	 */
	const COURSECODE = 183;
	
	/**
	 * Searching for the name of the lecturer
	 */
	const LECTURER = 184;
}
?>