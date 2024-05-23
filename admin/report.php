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
    <link rel="stylesheet" type="text/css" href="../css/report.css">
    <title>Trade Trunc .Inc - Report</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <div class="inventory-container">
      <h1>Trade Trunc .Inc</h1>
      <?php
        $sql = "SELECT inventory.Product_id, category.cat_title, inventory.Product_title, 
        inventory.Product_price, inventory.Product_desc 
 FROM inventory 
 JOIN category ON inventory.Product_cat = category.cat_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='inventory-table'>
  <tr>
      <th>ID</th>
      <th>Category</th>
      <th>Product Name</th>
      <th>Description</th>
      <th>Price</th>
  </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
      <td>".$row["Product_id"]."</td>
      <td>".$row["cat_title"]."</td>
      <td>".$row["Product_title"]."</td>
      <td>".$row["Product_desc"]."</td>
      <td>&#8369; ".number_format($row["Product_price"], 2)."</td>
    </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='no_result'>No Items found</p>";
}

$conn->close();
?>

      <button class="print-button" onclick="printInventory()">Print </button>
    </div>

    <script>
      function printInventory() {
        window.print();
      }
    </script>

  </body>

</html>