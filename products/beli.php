<?php 
session_start();

if (!isset($_SESSION['valid'])) {
    header('Location: ../auth/login.php');
    exit;
}
?>

<html>
<head>
    <title>beli barang</title>
</head>

<body>
<?php
require_once("../setup/connection.php");
if (isset($_POST['Submit'])) {    
    $nama_barang    = trim($_POST['nama_barang']);
    $user_id     = trim($_POST['user_id']);
    $nama_penerima   = trim($_POST['nama_penerima']);
    $alamat = trim($_POST['alamat']);
    $no_hp = trim($_POST['no_hp']);
    $total = trim($_POST['total']);
    $status_pembayaran = trim($_POST['status_pembayaran']);
    $order_id = trim($_POST['order_id']);
    $barang_id = trim($_POST['barang_id']);
    $harga = trim($_POST['harga']);
    $qty = trim($_POST['qty']);

    $loginId = $_SESSION['id'];
        
    if (empty($nama_barang) || empty($user_id) || empty($nama_penerima) || empty($alamat) || empty($no_hp) || empty($total) || empty($status_pembayaran) || empty($order_id) || empty($barang_id) || empty($nama_barang) || empty($harga) || empty($qty)) {
                
        if (empty($nama_barang)) {
            echo "<font color='red'>Name field is empty.</font><br/>";
        }
        
        if (empty($user_id)) {
            echo "<font color='red'>Quantity field is empty.</font><br/>";
        }
        
        if (empty($nama_penerima)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }

        if (empty($alamat)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }

        if (empty($no_hp)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }

        if (empty($total)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }

        if (empty($status_pembayaran)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }

        if (empty($order_id)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }

        if (empty($barang_id)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }

        if (empty($nama_barang)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }

        if (empty($harga)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }
        
        if (empty($qty)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }

        echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
    } else { 
        try {
            $stmt = $pdo->prepare("INSERT INTO orders ( user_id, nama_penerima, alamat, no_hp, total, status_pembayaran) 
                                   VALUES ( :user_id, :nama_penerima, :alamat, :no_hp, :total, :status_pembayaran)");
            $stmt->execute([
                ':user_id'     => $user_id,
                ':nama_penerima'   => $nama_penerima,
                ':alamat' => $alamat,
                ':no_hp' => $no_hp,
                ':total' => $total,
                ':status_pembayaran' => $status_pembayaran
            ]);
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, barang_id, nama_barang, harga, qty) 
                                   VALUES (:order_id, :barang_id, :nama_barang, :harga, :qty)");
            $stmt->execute([
                ':order_id'    => $order_id,
                ':barang_id'     => $barang_id,
                ':nama_barang'   => $nama_barang,
                ':harga' => $harga,
                ':qty' => $qty
            ]);

            echo "<font color='green'>Data added successfully.</font>";
            echo "<br/><a href='view.php'>View Result</a>";

        } catch (PDOException $e) {
            echo "<font color='red'>Error: " . htmlspecialchars($e->getMessage()) . "</font>";
        }
    }
}
?>
</body>
</html>
