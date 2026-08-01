<?php
session_start();
include "db_config.php";

// Verify session and cookie matching pattern from lecture slides
if (
    isset($_COOKIE["PHPSESSID"]) &&
    isset($_SESSION["user_id"]) &&
    $_COOKIE["PHPSESSID"] === session_id()
) {
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT * FROM users WHERE id=$user_id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
} else {
    echo "You are not logged in. Please <a href='login.php'>login</a>.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head><title>User Dashboard</title></head>
<body>
    <h2>Profile Details</h2>
    <p><img src="<?php echo $user['photo']; ?>" width="150" alt="Profile Photo"></p>
    <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>

    <br>
    <a href="update.php">Update Profile</a> | 
    <a href="delete.php" onclick="return confirm('Are you sure you want to delete your profile?');">Delete Profile</a> | 
    <a href="logout.php">Logout</a>
</body>
</html>