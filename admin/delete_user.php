<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "DELETE FROM user WHERE user_id='$user_id'";
    if ($conn->query($sql) === true) {
        header("Location: users.php");
        exit();
    } else {
        $error_message = "Error deleting user: " . $conn->error;
    }
} else {
    echo "<div class='error-message'>User ID not provided.</div>";
    exit();
}
