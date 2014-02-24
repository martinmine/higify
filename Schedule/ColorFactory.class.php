<?php

/**
 * Keeps track of which colors to use for each subject in the schedule
 */
class ColorFactory
{
    private $COLORS = array('blueTimeObject',
                            'greenTimeObject',
                            'redTimeObject',
                            'orangeTimeObject',
                            'yellowTimeObject');
                            
    const DEFAULT_COLOR = 'grayTimeObject';
    const COLOR_COUNT = 5;
    
    private $lastRecentlyUsed;
    private $keys;
    
    public function __construct()
    {
        $this->lastRecentlyUsed = 0;
        $this->codes = array();
    }
    
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