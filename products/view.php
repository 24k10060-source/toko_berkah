<?php 
session_start();

if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit;
}

require_once("../setup/connection.php"); 

try {
    $stmt = $pdo->prepare("SELECT * FROM barang ORDER BY id DESC");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . htmlspecialchars($e->getMessage()));
}
?>

<html>
<head>
    <title>Homepage</title>
</head>

<body>
    <a href="../index.php">Home</a> | 
    <a href="add.html">Add New Data</a> | 
    <a href="../auth/logout.php">Logout</a>
    <br/><br/>
    
    <table width='80%' border=0>
        <tr bgcolor='#CCCCCC'>
            <td>Nama</td>
            <td>Quantity</td>
            <td>Rupiah (IDR)</td>
            <td>Update</td>
        </tr>
        <?php foreach ($products as $res): ?>
            <tr>
                <td><?= htmlspecialchars($res['nama_barang']); ?></td>
                <td><?= htmlspecialchars($res['stok']); ?></td>
                <td><?= htmlspecialchars($res['harga']); ?></td>
                <td>
                    <a href="edit.php?id=<?= $res['id']; ?>">Edit</a> | 
                    <a href="delete.php?id=<?= $res['id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete?')">Delete</a> |
                       <a href="beli.html?id=<?= $res['id']; ?>">Beli</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>    
</body>
</html>
