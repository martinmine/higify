<?php

interface IPageController
{
	/**
	 * Function called when a controller gets registered to a template object,
	 * @return Array An associative array which contains the keys (variable names) and values (variable content)
	 *               tha shall be made available for output in the template files.
	 */
    public function onDisplay();
}

?>