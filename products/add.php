<?php 
session_start();

if (!isset($_SESSION['valid'])) {
    header('Location: ../auth/login.php');
    exit;
}
?>

<html>
<head>
    <title>Add Data</title>
</head>

<body>
<?php
require_once("../setup/connection.php");
if (isset($_POST['Submit'])) {    
    $name    = trim($_POST['name']);
    $qty     = trim($_POST['qty']);
    $price   = trim($_POST['price']);
    $loginId = $_SESSION['id'];
        
    if (empty($name) || empty($qty) || empty($price)) {
                
        if (empty($name)) {
            echo "<font color='red'>Name field is empty.</font><br/>";
        }
        
        if (empty($qty)) {
            echo "<font color='red'>Quantity field is empty.</font><br/>";
        }
        
        if (empty($price)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }
        
        echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
    } else { 
        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, qty, price, login_id) 
                                   VALUES (:name, :qty, :price, :loginId)");
            $stmt->execute([
                ':name'    => $name,
                ':qty'     => $qty,
                ':price'   => $price,
                ':loginId' => $loginId
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
