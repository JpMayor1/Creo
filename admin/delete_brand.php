<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $brand_id = $_GET['id'];

    $sql = "DELETE FROM brands WHERE brand_id='$brand_id'";
    if ($conn->query($sql) === true) {
        header("Location: brand.php");
        exit();
    } else {
        $error_message = "Error deleting brand: " . $conn->error;
    }
} else {
    echo "<div class='error-message'>Brand ID not provided.</div>";
    exit();
}
