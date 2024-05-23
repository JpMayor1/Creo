<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "SELECT * FROM user WHERE user_id='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $password = $row['password'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_username = $_POST['username'];
            $new_password = $_POST['password'];

            $sql_update = "UPDATE user SET username=?, password=? WHERE user_id=?";
            $stmt = $conn->prepare($sql_update);

            $stmt->bind_param("ssi", $new_username, $new_password, $user_id);

            if ($stmt->execute()) {
                header("Location: users.php");
                exit();
            } else {
                $error_message = "Error updating user: " . $stmt->error;
            }
        }

    } else {
        echo "<div class='error-message'>User not found.</div>";
        exit();
    }
} else {
    echo "<div class='error-message'>User ID not provided.</div>";
    exit();
}
?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="../css/edit_users.css">
    <title>Trade Trunc .Inc - Edit User</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <div class="body_container">
      <h1 class="users_header">Edit User</h1>
      <form class="user_form" method="post">
        <div class="input-group">
          <label>Title:</label>
          <input type="text" name="username"
            value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
          <label>Password:</label>
          <input type="text" name="password"
            value="<?php echo $password; ?>">
        </div>
        <div class="input-group">
          <input type="submit" value="Update User" class="btn">
        </div>
      </form>
    </div>
  </body>

</html>