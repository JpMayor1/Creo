<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand_title = $_POST['brand_title'];

    $sql = "SELECT * FROM brands WHERE brand_title='$brand_title'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='error-message'>Brand Already Exist</div>";
    } else {
        $sql = "INSERT INTO brands (brand_title) VALUES ('$brand_title')";

        if ($conn->query($sql) === true) {
            header("location: brand.php");
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="../css/add_brand.css">
    <title>Trade Trunc .Inc - Add Brand</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <div class="body_container">
      <h1 class="brand_title">Add Brand</h1>
      <form class="brand_form" method="post"
        action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class="input-group">
          <label>Title:</label>
          <input type="text" name="brand_title">
        </div>
        <div class="input-group">
          <input type="submit" value="Add Brand" class="btn">
        </div>
      </form>
    </div>
  </body>

</html>