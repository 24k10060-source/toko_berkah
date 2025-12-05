<?php 
session_start(); 
?>
<html>
<head>
    <title>Login</title>
</head>

<body>
<a href="../index.php">Home</a> <br />
<?php
require_once "../setup/connection.php"; 

if (isset($_POST['submit'])) {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    if ($user === "" || $pass === "") {
        echo "Either username or password field is empty.<br/>";
        echo "<a href='login.php'>Go back</a>";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE nama = :nama AND password = MD5(:password)");
            $stmt->execute([
                ':nama' => $user,
                ':password' => $pass
            ]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $_SESSION['valid'] = $row['nama'];
                $_SESSION['nama']  = $row['nama'];
                $_SESSION['id']    = $row['id'];

                header("Location: ../index.php");
                exit;
            } else {
                echo "Invalid username or password.<br/>";
                echo "<a href='login.php'>Go back</a>";
            }
        } catch (PDOException $e) {
            echo "Query failed: " . htmlspecialchars($e->getMessage());
        }
    }
} else {
?>
    <p><font size="+2">Login</font></p>
    <form name="form1" method="post" action="">
        <table width="75%" border="0">
            <tr> 
                <td width="10%">Username</td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr> 
                <td>Password</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr> 
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
<?php
}
?>
</body>
</html>
