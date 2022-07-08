<?php

$server = 'database-1.cvwyjl87rro2.us-east-1.rds.amazonaws.com:3306';
$username = 'admin';
$password = 'administrador';
$database = 'poy_cognitive';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>
