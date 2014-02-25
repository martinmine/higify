<?php

/**
 * Keeps track of which colors to use for each subject in the schedule
 */
class ColorFactory
{
    /**
     * All the CSS styles
     * @var array of string
     */
    private $COLORS = array('blueTimeObject',
                            'greenTimeObject',
                            'redTimeObject',
                            'orangeTimeObject',
                            'yellowTimeObject',
                            'lightRed',
                            'darkBlue',
                            'purple');
    
    /**
     * The default CSS rule
     */
    const DEFAULT_COLOR = 'grayTimeObject';
    /**
     * Amount of rules in $COLORS
     */
    const COLOR_COUNT = 8;
    
    /**
     * The index of the last used color in the $COLORS array
     * @var integer
     */
    private $lastRecentlyUsed;
    
    /**
     * Keeys track of which name is associated with which color, eg:
     * ['SomeCourseName'] = 'blueTimeObject'
     * @var mixed
     */
    private $codes;
    
    /**
     * Initializes the ColorFactory for use
     */
    public function __construct()
    {
        $this->lastRecentlyUsed = 0;
        $this->codes = array();
    }
    
    /**
     * Gets the proper CSS rule to append for one course name
     * @param string $key They key, eg. course name
     * @return string The CSS rule to append
     */
    public function produceCode($key)
    {
        if (strpos($key, '*') !== FALSE)
            return self::DEFAULT_COLOR;
            
        if (isset($this->codes[$key]))
            return $this->codes[$key];
        else
        {
            $i = $this->lastRecentlyUsed++ % self::COLOR_COUNT;
            $newColor = $this->COLORS[$i];
            $this->codes[$key] = $newColor;
            
            return $newColor;
        }
    }
}

?>