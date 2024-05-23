<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $Product_id = $_GET['id'];

    // Get the image name from the database
    $sql = "SELECT Product_image FROM inventory WHERE Product_id='$Product_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_name = $row['Product_image'];

        $image_path =  "../public/" . $image_name;
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        $delete_sql = "DELETE FROM inventory WHERE Product_id='$Product_id'";
        if ($conn->query($delete_sql) === true) {
            header("Location: inventory.php");
            exit();
        } else {
            $error_message = "Error deleting product: " . $conn->error;
        }
    } else {
        $error_message = "Product not found in the database.";
    }
} else {
    $error_message = "Product ID not provided.";
}

if (isset($error_message)) {
    echo "<div class='error-message'>$error_message</div>";
    exit();
}
