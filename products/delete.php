<?php 
session_start();

if (!isset($_SESSION['valid'])) {
    header('Location: ../auth/login.php');
    exit;
}

require_once("../setup/connection.php"); 
$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM barang WHERE id = :id");
        $stmt->execute([':id' => $id]);

        header("Location: view.php");
        exit;
    } catch (PDOException $e) {
        die("Error: " . htmlspecialchars($e->getMessage()));
    }
} else {
    die("Invalid request.");
}
?>
