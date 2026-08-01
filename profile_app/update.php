<?php
session_start();
include "db_config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT * FROM users WHERE id=$user_id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];

    if (isset($_FILES["photo"]) && is_uploaded_file($_FILES["photo"]["tmp_name"])) {
        $target_dir = "uploads/";
        $photo_name = time() . "_" . basename($_FILES["photo"]["name"]);
        $target_file = $target_dir . $photo_name;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

        $sql = "UPDATE users SET name='$name', email='$email', photo='$target_file' WHERE id=$user_id";
    } else {
        $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$user_id";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Update Profile</title></head>
<body>
    <h2>Update Profile Information</h2>
    <form method="POST" action="update.php" enctype="multipart/form-data">
        Name: <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br><br>
        Email: <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>
        Current Photo:<br>
        <img src="<?php echo $row['photo']; ?>" width="100"><br><br>
        New Photo (Optional): <input type="file" name="photo"><br><br>
        <button type="submit">Update Profile</button>
    </form>
    <br>
    <a href="dashboard.php">Cancel</a>
</body>
</html>