<?php
require_once('OutputType.class.php');
require_once('TimeTableView.class.php');
require_once('DOMDocumentView.class.php');
require_once('XMLDocumentView.class.php');
require_once('JSONView.class.php');

class TimeTableViewFactory
{
	/**
	 * Gets the view for the assigned type specified
	 * @param integer $type The view type
	 * @throws InvalidArgumentException If OutputType is an invalid/unknown type which is not implemented
	 * @return mixed The output of the view
	 */
	public static function getView($type)
	{
		switch ($type)
        {
            case OutputType::TIME_TABLE:
                {
					return new TimeTableView();
                    break;   
                }
            
            case OutputType::DOM_DOCUMENT:
                {
					return new DOMDOcumentView();
                    break;
                }
				
			case OutputType::XML_DOCUMENT:
				{
					return new XMLDocumentView();
					break;
				}
				
			case OutputType::JSON:
				{
					return new JSONView();
					break;
				}
			
            default:	// Invalid argument
                {
                    throw new InvalidArgumentException("The output type $type is unknown or not supported ");
                }
        }
	}
}
?>