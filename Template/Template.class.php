<?php
require_once('IPageController.interface.php');
require_once('IPageView.interface.php');

class Template
{
    /**
     * An array of all the template file names to be displayed on the page
     * @var Array An array of all the template file names
     */
    private $templates;
    
    /**
     * An associative array of a key pair (key, value) for all the values/objects 
     * to be displayed in the page template
     * @var Array Associative array of the key => value pair
     */
    private $values;
    
    /**
     * Prepares a new template 
     */
    public function __construct()
    {
        $this->templates = array();
        $this->values = array();
    }
    
    /**
     * Registers the controller for a website and gets the template values for its output
     * @param IPageController $controller 
     */
    public function registerController(IPageController $controller)
    {
        foreach ($controller->onDisplay() as $key => $value)
        {
            $this->values[$key] = $value;
        }
    }
    
    /**
     * Appends a template file to be rendered when the display function is called
     * @param string $URI The file name of the template
     */
    public function appendTemplate($URI)
    {
        $this->templates[] = $URI;
    }
    
    /**
     * Sets the value to be displayed on the website for example PAGE_TITLE
     * @param string $key   The key for the value, eg. PAGE_TITLE
     * @param string $value The value, for example 'Welcome!'
     */
    public function setValue($key, $value)
    {
        $values[$key] = $value;
    }
    
    /**
     * Sets all the values defined in setValue and from the IPageControllers and
     * renders all the template files to the user output
     */
    public function display()
    {
        foreach ($this->values as $key => $value)
        {
            $$key = $value;
        }
        
        foreach ($this->templates as $tplURI)
        {
            include('Tpl/' . $tplURI . '.tpl');
        }
    }
}

?>