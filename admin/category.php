<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';
?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="../css/category.css">
    <title>Trade Trunc .Inc - Categories</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <div class="category_container">
      <h1>Categories</h1>
      <div class="add_category_container">
        <a class="add_category_link" href="add_category.php">+ Add Category</a>
      </div>
      <?php
        $sql = "SELECT * FROM category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
    <tr>
    <th>Id</th>
    <th>Category Name</th>
    <th></th>
    <th></th>
    </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>".$row["cat_id"]."</td>
        <td>".$row["cat_title"]."</td>
        <td><a class='edit_category_link' href='edit_category.php?id=".$row["cat_id"]."'>Edit</a></td>
        <td><a class='delete_category_link' href='delete_category.php?id=".$row["cat_id"]."'>Delete</a></td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No categories found.</p>";
}

$conn->close();
?>
    </div>
  </body>

</html>