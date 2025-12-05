<?php 
session_start();

if (!isset($_SESSION['valid'])) {
    header('Location: ../auth/login.php');
    exit;
}

require_once("../setup/connection.php"); 

if (isset($_POST['update'])) {    
    $id    = $_POST['id'];
    $nama_barang  = trim($_POST['nama_barang']);
    $stok   = trim($_POST['stok']);
    $harga = trim($_POST['harga']);    
    
    if (empty($nama_barang) || empty($stok) || empty($harga)) {
        if (empty($nama_barang)) {
            echo "<font color='red'>nama_barang kosong.</font><br/>";
        }
        if (empty($stok)) {
            echo "<font color='red'>stok kosong.</font><br/>";
        }
        if (empty($harga)) {
            echo "<font color='red'>harga kosong.</font><br/>";
        }
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE barang 
                                   SET nama_barang = :nama_barang, stok = :stok, harga = :harga 
                                   WHERE id = :id");
            $stmt->execute([
                ':nama_barang'  => $nama_barang,
                ':stok'   => $stok,
                ':harga' => $harga,
                ':id'    => $id
            ]);

            header("Location: view.php");
            exit;

        } catch (PDOException $e) {
            echo "<font color='red'>Error: " . htmlspecialchars($e->getMessage()) . "</font>";
        }
    }
}

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM barang WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($res) {
            $nama_barang  = $res['nama_barang'];
            $stok   = $res['stok'];
            $harga = $res['harga'];
        } else {
            die("Product not found.");
        }

    } catch (PDOException $e) {
        die("Error: " . htmlspecialchars($e->getMessage()));
    }
} else {
    die("Invalid request.");
}
?>
<html>
<head>    
    <title>Edit Data</title>
</head>

<body>
    <a href="../index.php">Home</a> | 
    <a href="view.php">View Products</a> | 
    <a href="../auth/logout.php">Logout</a>
    <br/><br/>
    
    <form name="form1" method="post" action="edit.php">
        <table border="0">
            <tr> 
                <td>nama_barang</td>
                <td><input type="text" name="nama_barang" value="<?php echo htmlspecialchars($nama_barang); ?>"></td>
            </tr>
            <tr> 
                <td>Quantity</td>
                <td><input type="text" name="stok" value="<?php echo htmlspecialchars($stok); ?>"></td>
            </tr>
            <tr>
                <td>harga</td>
                <td><input type="text" name="harga" value="<?php echo htmlspecialchars($harga); ?>"></td>
            </tr>
            <tr>
                <td><input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"></td>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
</body>
</html>
