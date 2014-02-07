<?php
require_once('TimeEditAPIController.class.php');

$table = TimeEditAPIController::getTimeTable(161569, 182, 'ICS', 'TimeTable', true);


echo 'Fetched time table with ' . $table->count() . ' elements';

?>