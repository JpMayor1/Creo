<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) {
            $_SESSION['username'] = $username;
            header("Location: admin/index.php");
            exit();
        } else {
            echo "<div class='error-message'>Invalid password</div>";
        }
    } else {
        echo "<div class='error-message'>No user found</div>";
    }
}
?>

<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="css/auth.css">
    <title>Trade Trunc .Inc - Login</title>
  </head>

  <body>
    <h1>Welcome to Trade Trunc .Inc</h1>
    <div class="container">
      <h1>Login</h1>
      <form method="post"
        action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class="input-group">
          <label>Username:</label>
          <input type="text" name="username">
        </div>
        <div class="input-group">
          <label>Password:</label>
          <input type="password" name="password">
        </div>
        <div class="input-group">
          <input type="submit" value="Login" class="btn">
        </div>
        <div class="register-link">
          <a href="register.php">Register an Account</a>
        </div>
      </form>
    </div>
  </body>

</html>