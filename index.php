<?php 
session_start(); 
?>
<html>
<head>
    <title>Homepage</title>
    <link href="setup/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="header">
        Welcome to Toko Berkah
    </div>
    <?php
    if (isset($_SESSION['valid'])) {
        require_once "setup/connection.php";

        $stmt = $pdo->query("SELECT * FROM users");

        ?>
            Welcome <?php echo htmlspecialchars($_SESSION['name']); ?> ! 
            <a href='../auth/logout.php'>Logout</a><br/>
            <br/>
            <a href='products/view.php'>View and Add Products</a>
            <br/><br/>
        <?php
    } else {
        echo "You must be logged in to view this page.<br/><br/>";
        echo "<a href='auth/login.php'>Login</a> | <a href='auth/register.php'>Register</a>";
    }
    ?>
    <div id="footer">
    </div>
</body>
</html>
