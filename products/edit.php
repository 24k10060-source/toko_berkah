<?php 
session_start();

if (!isset($_SESSION['valid'])) {
    header('Location: ../auth/login.php');
    exit;
}

require_once("../setup/connection.php"); 

if (isset($_POST['update'])) {    
    $id    = $_POST['id'];
    $name  = trim($_POST['name']);
    $qty   = trim($_POST['qty']);
    $Rupiah = trim($_POST['Rupiah']);    
    
    if (empty($name) || empty($qty) || empty($Rupiah)) {
        if (empty($name)) {
            echo "<font color='red'>Name field is empty.</font><br/>";
        }
        if (empty($qty)) {
            echo "<font color='red'>Quantity field is empty.</font><br/>";
        }
        if (empty($Rupiah)) {
            echo "<font color='red'>Rupiah field is empty.</font><br/>";
        }
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE products 
                                   SET name = :name, qty = :qty, Rupiah = :Rupiah 
                                   WHERE id = :id");
            $stmt->execute([
                ':name'  => $name,
                ':qty'   => $qty,
                ':Rupiah' => $Rupiah,
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
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($res) {
            $name  = $res['name'];
            $qty   = $res['qty'];
            $Rupiah = $res['Rupiah'];
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
                <td>Name</td>
                <td><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></td>
            </tr>
            <tr> 
                <td>Quantity</td>
                <td><input type="text" name="qty" value="<?php echo htmlspecialchars($qty); ?>"></td>
            </tr>
            <tr>
                <td>Rupiah</td>
                <td><input type="text" name="Rupiah" value="<?php echo htmlspecialchars($Rupiah); ?>"></td>
            </tr>
            <tr>
                <td><input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"></td>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
</body>
</html>
