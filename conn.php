<?php
$host = 'localhost';
$db   = 'crud_db';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db";

$pdo = new PDO($dsn, $user, $pass);

?>