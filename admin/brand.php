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
    <link rel="stylesheet" type="text/css" href="../css/brand.css">
    <title>Trade Trunc .Inc - Brand</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <div class="brand_container">
      <h1>Brands</h1>
      <div class="add_brand_container">
        <a class="add_brand_link" href="add_brand.php">+ Add Brand</a>
      </div>
      <?php
        $sql = "SELECT * FROM brands";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
    <tr>
    <th>Id</th>
    <th>Brand Name</th>
    <th></th>
    <th></th>
    </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>".$row["brand_id"]."</td>
        <td>".$row["brand_title"]."</td>
        <td><a class='edit_brand_link' href='edit_brand.php?id=".$row["brand_id"]."'>Edit</a></td>
        <td><a class='delete_brand_link' href='delete_brand.php?id=".$row["brand_id"]."'>Delete</a></td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No brand found.</p>";
}

$conn->close();
?>
    </div>
  </body>

</html>