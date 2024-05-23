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
    <link rel="stylesheet" type="text/css" href="../css/inventory.css">
    <title>Trade Trunc .Inc - Inventory</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <div class="inventory-container">
      <h1>Inventory</h1>
      <?php
        $sql = "SELECT inventory.Product_id, category.cat_title, brands.brand_title, inventory.Product_title, 
        inventory.Product_price, inventory.Product_desc, inventory.Product_image, inventory.Product_keywords 
 FROM inventory 
 JOIN category ON inventory.Product_cat = category.cat_id 
 JOIN brands ON inventory.Product_brand = brands.brand_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='inventory-table'>
  <tr>
      <th>ID</th>
      <th>Image</th>
      <th>Keywords</th>
      <th>Title</th>
      <th>Category</th>
      <th>Brand</th>
      <th>Description</th>
      <th>Price</th>
      <th></th>
      <th></th>
  </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
      <td>".$row["Product_id"]."</td>
      <td><img src='../public/".$row["Product_image"]."' alt='Item'></td>
      <td>".$row["Product_keywords"]."</td>
      <td>".$row["Product_title"]."</td>
      <td>".$row["cat_title"]."</td>
      <td>".$row["brand_title"]."</td>
      <td>".$row["Product_desc"]."</td>
      <td>&#8369; ".number_format($row["Product_price"], 2)."</td>
      <td><a class='edit_inventory_link' href='edit_inventory.php?id=".$row["Product_id"]."'>Edit</a></td>
      <td><a class='delete_inventory_link' href='delete_inventory.php?id=".$row["Product_id"]."'>Delete</a></td>
    </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='no_result'>No Items found</p>";
}

$conn->close();
?>
    </div>
  </body>

</html>