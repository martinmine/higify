<?php

require_once('DatabaseManager.class.php');

$pdo = DatabaseManager::getDB();
$query = $pdo->prepare('SELECT * FROM user WHERE id = 1');
$query->execute();

$data = $query->fetch(PDO::FETCH_ASSOC);

print_r($data);


?>