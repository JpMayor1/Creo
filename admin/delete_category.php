<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cat_id = $_GET['id'];

    $sql = "DELETE FROM category WHERE cat_id='$cat_id'";
    if ($conn->query($sql) === true) {
        header("Location: category.php");
        exit();
    } else {
        $error_message = "Error deleting category: " . $conn->error;
    }
} else {
    echo "<div class='error-message'>Category ID not provided.</div>";
    exit();
}
