<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cat_id = $_GET['id'];

    $sql = "SELECT * FROM category WHERE cat_id='$cat_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $cat_title = $row['cat_title'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_cat_title = $_POST['cat_title'];

            $sql_update = "UPDATE category SET cat_title='$new_cat_title' WHERE cat_id='$cat_id'";
            if ($conn->query($sql_update) === true) {
                header("Location: category.php");
                exit();
            } else {
                $error_message = "Error updating category: " . $conn->error;
            }
        }
    } else {
        echo "<div class='error-message'>Category not found.</div>";
        exit();
    }
} else {
    echo "<div class='error-message'>Category ID not provided.</div>";
    exit();
}
?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="../css/add_category.css">
    <title>Trade Trunc .Inc - Edit Category</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <div class="body_container">
      <h1 class="category_title">Edit Category</h1>
      <form class="category_form" method="post">
        <div class="input-group">
          <label>Title:</label>
          <input type="text" name="cat_title"
            value="<?php echo $cat_title; ?>">
        </div>
        <div class="input-group">
          <input type="submit" value="Update Category" class="btn">
        </div>
      </form>
    </div>
  </body>

</html>