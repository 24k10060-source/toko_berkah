<?php
$databaseHost = 'localhost';
$databaseName = 'toko_berkah_elektronik';
$databaseUsername = 'root';
$databasePassword = '';

try {
    $pdo = new PDO("mysql:host=$databaseHost;dbname=$databaseName;charset=utf8", $databaseUsername, $databasePassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
