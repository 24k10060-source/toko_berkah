<html>
<head>
    <title>Register</title>
</head>

<body>
<a href="../index.php">Home</a> <br />
<?php
require_once("../setup/connection.php"); 

if (isset($_POST['submit'])) {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $user  = trim($_POST['username']);
    $pass  = trim($_POST['password']);

    if ($user === "" || $pass === "" || $name === "" || $email === "") {
        echo "All fields should be filled. Either one or many fields are empty.<br/>";
        echo "<a href='register.php'>Go back</a>";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (nama, email, password) 
                                   VALUES (:nama, :email, MD5(:password))");
            $stmt->execute([
                ':nama'     => $name,
                ':email'    => $email,
                ':password' => $pass
            ]);

            echo "Registration successful!<br/>";
            echo "<a href='login.php'>Login</a>";
        } catch (PDOException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    }
} else {
?>
    <p><font size="+2">Register</font></p>
    <form name="form1" method="post" action="">
        <table width="75%" border="0">
            <tr> 
                <td width="10%">Full Name</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr> 
                <td>Email</td>
                <td><input type="text" name="email"></td>
            </tr>            
            <tr> 
                <td>Username</td>
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
