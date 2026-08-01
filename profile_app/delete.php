<?php
session_start();
include "db_config.php";

if (isset($_SESSION["user_id"])) {
    $id = $_SESSION["user_id"];
    $sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        session_unset();
        session_destroy();
        setcookie("PHPSESSID", "", time() - 3600, "/");

        header("Location: register.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: login.php");
    exit();
}
?>