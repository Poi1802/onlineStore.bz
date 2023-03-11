<?php
$host = 'localhost';
$db = 'online_store';
$login = 'root';
$pass = '';
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db", $login, $pass, $options);
} catch (\Throwable $th) {
  die('Connection error to database');
}