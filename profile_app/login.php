<?php
session_start();
include "db_config.php";

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Store session variables
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];

        // Set session ID cookie
        setcookie("PHPSESSID", session_id(), time() + 3600, "/");

        header("Location: dashboard.php");
        exit();
    } else {
        $msg = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h2>User Login</h2>
    <?php if (!empty($msg)) echo "<p style='color:red;'>$msg</p>"; ?>
    <form method="POST" action="login.php">
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <br>
    <a href="register.php">Don't have an account? Register here</a>
</body>
</html>