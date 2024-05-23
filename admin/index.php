<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';

$categories = [];
$sql = "SELECT * FROM category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

$brands = [];
$sql = "SELECT * FROM brands";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $brands[] = $row;
    }
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_title = $_POST['product_title'];
    $product_cat = $_POST['product_cat'];
    $product_brand = $_POST['product_brand'];
    $product_price = $_POST['product_price'];
    $product_desc = $_POST['product_desc'];
    $product_keywords = $_POST['product_keywords'];

    if (empty($product_title) || empty($product_cat) || empty($product_brand) || empty($product_price) || empty($product_desc) || empty($product_keywords) || empty($_FILES['product_image']['name'])) {
        $error_message = 'All fields are required.';
    } else {

        $target_dir = "../public/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error_message = 'File is not an image.';
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            $error_message = 'Sorry, file already exists.';
            $uploadOk = 0;
        }

        if ($_FILES["product_image"]["size"] > 500000) {
            $error_message = 'Sorry, your file is too large.';
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error_message = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
            $uploadOk = 0;
        }

        if ($uploadOk !== 0) {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $product_image = basename($_FILES["product_image"]["name"]);

                $sql = "INSERT INTO inventory (Product_cat, Product_brand, Product_title, Product_price, Product_desc, Product_image, Product_keywords)
              VALUES ('$product_cat', '$product_brand', '$product_title', '$product_price', '$product_desc', '$product_image', '$product_keywords')";

                if ($conn->query($sql) === true) {
                    header("location: inventory.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $error_message = 'Sorry, there was an error uploading your file.';
            }
        }

        $conn->close();
    }

}
?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="../css/add_product.css">
    <title>Trade Trunc .Inc - Add Item</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <?php if ($error_message): ?>
    <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <div class="home_container">
      <h1>Add Item</h1>
      <form method="post"
        action="<?php echo $_SERVER['PHP_SELF'];?>"
        enctype="multipart/form-data" class="product-form">
        <div class="input-group">
          <label for="product_image">Image:</label>
          <input type="file" id="product_image" name="product_image" class="input-field">
        </div>

        <div class="input-group">
          <label for="product_keywords">Keyword:</label>
          <input type="text" id="product_keywords" name="product_keywords" class="input-field">
        </div>

        <div class="input-group">
          <label for="product_title">Title:</label>
          <input type="text" id="product_title" name="product_title" class="input-field">
        </div>

        <div class="input-group">
          <label for="product_cat">Category:</label>
          <select id="product_cat" name="product_cat" class="input-field">
            <?php foreach ($categories as $category): ?>
            <option
              value="<?php echo $category['cat_id']; ?>">
              <?php echo $category['cat_title']; ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="input-group">
          <label for="product_brand">Brand:</label>
          <select id="product_brand" name="product_brand" class="input-field">
            <?php foreach ($brands as $brand): ?>
            <option
              value="<?php echo $brand['brand_id']; ?>">
              <?php echo $brand['brand_title']; ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="input-group">
          <label for="product_price">Price:</label>
          <input type="text" id="product_price" name="product_price" class="input-field">
        </div>

        <div class="input-group">
          <label for="product_desc">Description:</label>
          <textarea id="product_desc" name="product_desc" class="textarea-field"></textarea>
        </div>

        <input type="submit" value="Add Product" class="submit-btn">
      </form>
    </div>
  </body>

</html>