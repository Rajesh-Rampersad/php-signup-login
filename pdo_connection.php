<?php

$host = "localhost";
$dbname = "login_db";
$username = "rajesh";
$password = "123456789";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}