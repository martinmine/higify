<?php
require_once('ScheduleLane.class.php');
require_once('ScheduleObject.class.php');

$lane = new ScheduleLane();

// DATA SET 1
$t1 = new ScheduleObject(1, "t1", "In the void", new DateTime("2014-01-01 12:00"), new DateTime("2014-01-01 12:15"));
$t2 = new ScheduleObject(2, "t2", "In the void", new DateTime("2014-01-01 12:00"), new DateTime("2014-01-01 12:15"));

// DATA SET 2
$t3 = new ScheduleObject(3, "t3", "In the void", new DateTime("2014-01-01 13:00"), new DateTime("2014-01-01 13:15"));
$t4 = new ScheduleObject(4, "t4", "In the void", new DateTime("2014-01-01 13:00"), new DateTime("2014-01-01 13:10"));
$t5 = new ScheduleObject(5, "t5", "In the void", new DateTime("2014-01-01 13:10"), new DateTime("2014-01-01 13:30"));
$t6 = new ScheduleObject(6, "t6", "In the void", new DateTime("2014-01-01 13:25"), new DateTime("2014-01-01 13:45"));
$t7 = new ScheduleObject(7, "t7", "In the void", new DateTime("2014-01-01 13:30"), new DateTime("2014-01-01 13:40"));
$t7b = new ScheduleObject(8, "t7b", "In the void", new DateTime("2014-01-01 13:40"), new DateTime("2014-01-01 13:50"));


// DATA SET 3
$t8 = new ScheduleObject(8, "t8", "In the void", new DateTime("2014-01-01 14:00"), new DateTime("2014-01-01 15:00"));
$t9 = new ScheduleObject(9, "t9", "In the void", new DateTime("2014-01-01 14:05"), new DateTime("2014-01-01 14:20"));
$t10 = new ScheduleObject(10, "t10", "In the void", new DateTime("2014-01-01 14:15"), new DateTime("2014-01-01 14:30"));
$t11 = new ScheduleObject(11, "t11", "In the void", new DateTime("2014-01-01 14:25"), new DateTime("2014-01-01 14:40"));
$t12 = new ScheduleObject(12, "t12", "In the void", new DateTime("2014-01-01 14:40"), new DateTime("2014-01-01 14:50"));

// DATA SET 4
$t13 = new ScheduleObject(13, "t13", "In the void", new DateTime("2014-01-01 15:00"), new DateTime("2014-01-01 15:25"));
$t14 = new ScheduleObject(14, "t14", "In the void", new DateTime("2014-01-01 15:05"), new DateTime("2014-01-01 15:30"));
$t15 = new ScheduleObject(15, "t15", "In the void", new DateTime("2014-01-01 15:10"), new DateTime("2014-01-01 15:25"));
$t16 = new ScheduleObject(16, "t13", "In the void", new DateTime("2014-01-01 15:25"), new DateTime("2014-01-01 15:30"));


$lane->insertItem($t1);
$lane->insertItem($t2);

$lane->insertItem($t3);
$lane->insertItem($t4);
$lane->insertItem($t5);
$lane->insertItem($t6);
$lane->insertItem($t7);
$lane->insertItem($t7b);


$lane->insertItem($t8);
$lane->insertItem($t9);
$lane->insertItem($t10);
$lane->insertItem($t11);
$lane->insertItem($t12);

$lane->insertItem($t13);
$lane->insertItem($t14);
$lane->insertItem($t15);
$lane->insertItem($t16);

$objects = $lane->getLane();

foreach ($objects as $laneObject)
{
    echo $laneObject->getID();
    echo '> ';
    echo $laneObject->getIndent();
    echo '/';
    echo $laneObject->getIndentMax();
    echo '<br/>';
}
?>