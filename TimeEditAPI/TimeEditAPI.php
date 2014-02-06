<?php
require_once('TimeEditAPIController.class.php');

$controller = new TimeEditAPIController('https://web.timeedit.se/hig_no/db1/timeedit/p/open/r.csv?sid=3&h=t&p=0.minutes,2.months&objects=161569.182&ox=0&types=0&fe=0');
$dom = $controller->getDOM();
echo $dom->saveXML();
echo "test";

?>