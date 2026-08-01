<?php
include "db_config.php";

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        $msg = "Passwords do not match!";
    } else {
        // Handle file upload according to lecture slides
        if (isset($_FILES["photo"]) && is_uploaded_file($_FILES["photo"]["tmp_name"])) {
            $target_dir = "uploads/";
            $photo_name = time() . "_" . basename($_FILES["photo"]["name"]);
            $target_file = $target_dir . $photo_name;

            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO users (name, email, password, photo) VALUES ('$name', '$email', '$password', '$target_file')";
                if ($conn->query($sql) === TRUE) {
                    header("Location: login.php");
                    exit();
                } else {
                    $msg = "Error: " . $conn->error;
                }
            } else {
                $msg = "Failed to upload photo.";
            }
        } else {
            $msg = "Please upload a profile photo.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
    <h2>User Registration</h2>
    <?php if (!empty($msg)) echo "<p style='color:red;'>$msg</p>"; ?>
    <form method="POST" action="register.php" enctype="multipart/form-data">
        Name: <input type="text" name="name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        Confirm Password: <input type="password" name="confirm_password" required><br><br>
        Photo: <input type="file" name="photo" required><br><br>
        <button type="submit">Register</button>
    </form>
    <br>
    <a href="login.php">Already have an account? Login here</a>
</body>
</html>