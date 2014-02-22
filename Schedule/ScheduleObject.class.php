<?php

class ScheduleObject
{
    /**
     * An unique ID of the schedule object
     * @var integer
     */
    private $id;
    
    /**
     * The title of the object, eg. WWW-technology
     * @var string
     */
    private $title;
    
    /**
     * The location of the object, eg. K105
     * @var string
     */
    private $location;
    
    /**
     * The time when the class begins
     * @var DateTime
     */
    private $start;
    
    /**
     * The time when the class ends
     * @var DateTime
     */
    private $end;
    
    /**
     * The position in the sliced up lane this shall be placed
     * @var integer
     */
    private $indent;
    
    /**
     * Decides the width for this element in the time table,
     * if the width is 100, the width for this item will be 100 / $indentMax
     * @var integer
     */
    private $indentMax;
    
    /**
     * The previous ScheduleObject in the time table
     * @var ScheduleObject
     */
    private $previous;
    
    /**
     * Creates a new ScheduleObject
     * @param integer  $id       Unique ID for the object
     * @param string   $title    Title of the object
     * @param string   $location Where the item shall be held
     * @param DateTime $start    Start time
     * @param DateTime $end      End time
     */
    public function __construct($id, $title, $location, $start, $end)
    {
        $this->id = $id;
        $this->title = $title;
        $this->location = $location;
        $this->start = $start;
        $this->end = $end;
        $this->indent = 1;
        $this->indentMax = 1;
        $this->previous = NULL;
    }
    
    /**
     * Gets the ID of the schedule object
     * @return integer
     */
    public function getID()
    {
        return $this->id;
    }
    
    /**
     * Gets the title of the schedule object
     * @return string
     */
    public function getTitle()
    {
        return $this->title;   
    }
    
    /**
     * Gets the location of the schedule objct
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
    
    /**
     * Get the start point for the object
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }
    
    /**
     * The time when the object ends
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }
    
    /**
     * Get indentation for the object
     * @return intger
     */
    public function getIndent()
    {
        return $this->indent;
    }
    
    /**
     * Sets the indentation for the object
     * @param integer $indent The new indentation
     */
    public function setIndent($indent)
    {
        $this->indent = $indent;
    }
    
    /**
     * Gets the max indent for the object
     * @return integer
     */
    public function getIndentMax()
    {
        return $this->indentMax;
    }
    
    /**
     * Sets the max indent for the object
     * @param integer $max New max indent
     */
    public function setIndentMax($max)
    {
        $this->indentMax = $max;
    }
    
    /**
     * Gets the previous item in the formated group if any
     * @return ScheduleObject
     */
    public function getPrevious()
    {
        return $this->previous;
    }
    
    /**
     * Sets the previous object in the formated group
     * @param ScheduleObject $obj 
     */
    public function setPrevious(ScheduleObject $obj)
    {
        $this->previous = $obj;
    }
    
    /**
     * Checks if two items overlaps
     * @param ScheduleObject $item The item to compare with
     * @return boolean
     */
    public function overlaps(ScheduleObject $item)
    {
        if ($item->start == $this->start && $item->end == $this->end)
            return true;
        
        return (($item->start > $this->start && $item->start < $this->end)  // item's start between this->start/end
                || ($item->end > $this->start && $item->end < $this->end)); // item's end between this->start/end
    }
}

?>