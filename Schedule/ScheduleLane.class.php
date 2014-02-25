<?php

/**
 * Manages the objects in a lane for the schedule
 */
class ScheduleLane
{
    /**
     * Array of all the time objects in this lane
     * @var Array of ScheduleObjects
     */
    private $lanes;
    
    /**
     * Length of $lanes/amount of ScheduleObjects in $lanes
     * @var integer
     */
    private $count;
    
    /**
     * Initializes an empty schedule lane
     */
    public function __construct()
    {
        $this->lanes = array();
        $this->count = 0;
    }
    
    /**
     * Inserts one item to the schedule lane
     * @param ScheduleObject $item 
     */
    public function insertItem(ScheduleObject $item)
    {
        if ($this->count > 0)
            $this->prepareItem($item);
        
        $this->lanes[$this->count++] = $item;
        
    }
    
    /**
     * Prepares the item and the lane (if needed) for the new item. 
     * If there are any colisions among items (objects timespan overlaps), 
     * the item will be formated among with the other objects
     * @param ScheduleObject $item 
     */
    private function prepareItem(ScheduleObject $item)
    {
        $prev = $this->lanes[$this->count - 1]; // Get the previous added element
        
        // The previous element is not a part of a grouping and does not overlap with anything
        if ($prev->getPrevious() === NULL && !$prev->overlaps($item)) 
            return;
        
        $max = $prev->getIndentMax(); // The index of the last sub-lane
        $free = array_fill(1, $max, true); // Initialize the array with flags for if a lane is taken or not
        $flagged = false;
        
        // Look for overlapping elements and flag these in the free array if there are any overlapping
        // elements. Then move backwards in the time-schedule (previous)
        while ($prev !== NULL) // Find overlapping elements
        {
            if ($prev->overlaps($item))               // Item overlaps 
            {
                $free[$prev->getIndent()] = false;    // Flag this sub-lane
                $flagged = true;
            }
            
            $prev = $prev->getPrevious();
        }
        
        // This means the previous item was a part of another group, but the item does not conflict
        // with any of the other items
        if (!$flagged) 
            return;
        
        $i = 1; // The position where $item will be put
        while ($i <= $max && !$free[$i]) $i++; // Find the free position in $free

        if ($i > $max) // FULL row, all the free slots in $free are set to false, add new sublane
        {
            $max++; 
            $prev = $this->lanes[$this->count - 1];
            do
            {
                $prev->setIndentMax($max);    // Update the max indent of the item
                $prev = $prev->getPrevious(); // Then move backwards
            }
            while ($prev !== NULL);           // Iterate as long as we have items left 
        }
        
        $item->setIndent($i);                 // Set properties for item
        $item->setIndentMax($max);
        $item->setPrevious($this->lanes[$this->count - 1]);
    }
    
    /**
     * Gets the lane for this scheduleLane
     * @return Array of ScheduleObject
     */
    public function getLane()
    {
        return $this->lanes;
    }
}

?>