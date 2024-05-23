<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cat_title = $_POST['cat_title'];

    $sql = "SELECT * FROM category WHERE cat_title='$cat_title'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='error-message'>Category Already Exist</div>";
    } else {
        $sql = "INSERT INTO category (cat_title) VALUES ('$cat_title')";

        if ($conn->query($sql) === true) {
            header("location: category.php");
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="../css/add_category.css">
    <title>Trade Trunc .Inc - Add Categories</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <div class="body_container">
      <h1 class="category_title">Add Category</h1>
      <form class="category_form" method="post"
        action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class="input-group">
          <label>Title:</label>
          <input type="text" name="cat_title">
        </div>
        <div class="input-group">
          <input type="submit" value="Add Category" class="btn">
        </div>
      </form>
    </div>
  </body>

</html>