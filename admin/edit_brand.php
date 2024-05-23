<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $brand_id = $_GET['id'];

    $sql = "SELECT * FROM brands WHERE brand_id='$brand_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $brand_title = $row['brand_title'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_brand_title = $_POST['brand_title'];

            $sql_update = "UPDATE brands SET brand_title='$new_brand_title' WHERE brand_id='$brand_id'";
            if ($conn->query($sql_update) === true) {
                header("Location: brand.php");
                exit();
            } else {
                $error_message = "Error updating brand: " . $conn->error;
            }
        }
    } else {
        echo "<div class='error-message'>Brand not found.</div>";
        exit();
    }
} else {
    echo "<div class='error-message'>Brand ID not provided.</div>";
    exit();
}
?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="../css/add_brand.css">
    <title>Trade Trunc .Inc - Edit Brand</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <div class="body_container">
      <h1 class="brand_title">Edit Brand</h1>
      <form class="brand_form" method="post">
        <div class="input-group">
          <label>Title:</label>
          <input type="text" name="brand_title"
            value="<?php echo $brand_title; ?>">
        </div>
        <div class="input-group">
          <input type="submit" value="Update Brand" class="btn">
        </div>
      </form>
    </div>
  </body>

</html>