<?php
/**
* Method for setting up a PDO connection to the MySQL database holding the
* Oblig1 data.
*
* @return PDO the PDO object connecting to the MySQL database.
* @throws PDOException
*/

function openDB() {
    $db = new PDO('mysql:host=phpmyadmin.obbahhost.com;dbname=higify;charset=utf8',
                  'higifydev', '6DLqsad9rbmFjcL7abvYDnzy');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

?>