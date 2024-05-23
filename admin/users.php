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
    <link rel="stylesheet" type="text/css" href="../css/users.css">
    <title>Trade Trunc .Inc - Users</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <div class="users_container">
      <h1>Users</h1>
      <?php
        $sql = "SELECT * FROM user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
    <tr>
    <th>Id</th>
    <th>User Name</th>
    <th>Password</th>
    <th></th>
    <th></th>
    </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>".$row["user_id"]."</td>
        <td>".$row["username"]."</td>
        <td>".$row["password"]."</td>
        <td><a class='edit_user_link' href='edit_user.php?id=".$row["user_id"]."'>Edit</a></td>
        <td><a class='delete_user_link' href='delete_user.php?id=".$row["user_id"]."'>Delete</a></td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No user found.</p>";
}

$conn->close();
?>
    </div>
  </body>

</html>