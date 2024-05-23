<?php
include 'db_connect.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error_message = "User Already Exist" ;
    } else {
        $sql = "INSERT INTO user (username, password) VALUES ('$username', '$password')";

        if ($conn->query($sql) === true) {
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="css/auth.css">
    <title>Trade Trunc .Inc - Register</title>
  </head>

  <body>
    <div class="container">
      <h1>Register</h1>
      <?php if ($error_message): ?>
      <div class="error-message"><?php echo $error_message; ?></div>
      <?php endif; ?>
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
          <input type="submit" value="Register" class="btn">
        </div>
        <div class="register-link">
          <a href="index.php">Login an Account</a>
        </div>
      </form>
    </div>
  </body>

</html>