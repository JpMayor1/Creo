<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include '../db_connect.php';

$error_message = '';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch current product details
    $sql = "SELECT * FROM inventory WHERE Product_id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_cat = $row['Product_cat'];
        $product_brand = $row['Product_brand'];
        $product_title = $row['Product_title'];
        $product_price = $row['Product_price'];
        $product_desc = $row['Product_desc'];
        $product_image = $row['Product_image'];
        $product_keywords = $row['Product_keywords'];
    } else {
        echo "No product found";
        exit();
    }
} else {
    header("Location: inventory.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_cat = $_POST['product_cat'];
    $product_brand = $_POST['product_brand'];
    $product_title = $_POST['product_title'];
    $product_price = $_POST['product_price'];
    $product_desc = $_POST['product_desc'];
    $product_keywords = $_POST['product_keywords'];

    if (empty($product_title) || empty($product_cat) || empty($product_brand) || empty($product_price) || empty($product_desc) || empty($product_keywords)) {
        $error_message = 'All fields are required.';
    } else {
        $update_image = false;

        if ($_FILES["product_image"]["name"]) {
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

                    if ($product_image && file_exists($target_dir . $product_image)) {
                        unlink($target_dir . $product_image);
                    }

                    $product_image = basename($_FILES["product_image"]["name"]);
                    $update_image = true;
                } else {
                    $error_message = 'Sorry, there was an error uploading your file.';
                    $update_image = false;
                }
            }
        }

        if ($update_image) {
            $sql = "UPDATE inventory SET Product_cat='$product_cat', Product_brand='$product_brand', Product_title='$product_title', Product_price='$product_price', Product_desc='$product_desc', Product_image='$product_image', Product_keywords='$product_keywords' WHERE Product_id='$product_id'";
        } else {
            $sql = "UPDATE inventory SET Product_cat='$product_cat', Product_brand='$product_brand', Product_title='$product_title', Product_price='$product_price', Product_desc='$product_desc', Product_keywords='$product_keywords' WHERE Product_id='$product_id'";
        }

        if ($conn->query($sql) === true) {
            header("Location: inventory.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $conn->close();
    }


}
?>

<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="../css/edit_inventory.css">
    <title>Trade Trunc .Inc - Edit Product</title>
  </head>

  <body>
    <?php include 'navigation.php'; ?>
    <?php if ($error_message): ?>
    <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <div class="inventory-container">
      <h1 class="title">Edit Product</h1>
      <form action="edit_inventory.php?id=<?php echo $product_id; ?>"
        method="post" enctype="multipart/form-data" class="edit-form">
        <div class="input-group">
          <label for="product_image" class="input-label">Image:</label>
          <input type="file" id="product_image" name="product_image" class="input-field">
          <?php if ($product_image): ?>
          <img src="../public/<?php echo $product_image; ?>"
            alt="<?php echo $product_title; ?>"
            class="current-image">
          <?php endif; ?>
        </div>

        <div class="input-group">
          <label for="product_keywords" class="input-label">Keywords:</label>
          <input type="text" id="product_keywords" name="product_keywords" class="input-field"
            value="<?php echo $product_keywords; ?>">
        </div>

        <div class="input-group">
          <label for="product_title" class="input-label">Title:</label>
          <input type="text" id="product_title" name="product_title" class="input-field"
            value="<?php echo $product_title; ?>">
        </div>

        <div class="input-group">
          <label for="product_cat" class="input-label">Category:</label>
          <select id="product_cat" name="product_cat" class="input-field">
            <?php
                    $sql = "SELECT * FROM category";
$result = $conn->query($sql);
while ($cat = $result->fetch_assoc()) {
    $selected = $cat['cat_id'] == $product_cat ? "selected" : "";
    echo "<option value='" . $cat['cat_id'] . "' $selected>" . $cat['cat_title'] . "</option>";
}
?>
          </select>
        </div>

        <div class="input-group">
          <label for="product_brand" class="input-label">Brand:</label>
          <select id="product_brand" name="product_brand" class="input-field">
            <?php
$sql = "SELECT * FROM brands";
$result = $conn->query($sql);
while ($brand = $result->fetch_assoc()) {
    $selected = $brand['brand_id'] == $product_brand ? "selected" : "";
    echo "<option value='" . $brand['brand_id'] . "' $selected>" . $brand['brand_title'] . "</option>";
}
?>
          </select>
        </div>

        <div class="input-group">
          <label for="product_price" class="input-label">Price:</label>
          <input type="text" id="product_price" name="product_price" class="input-field"
            value="<?php echo $product_price; ?>">
        </div>

        <div class="input-group">
          <label for="product_desc" class="input-label">Description:</label>
          <textarea id="product_desc" name="product_desc"
            class="textarea-field"><?php echo $product_desc; ?></textarea>
        </div>

        <input type="submit" value="Update Product" class="submit-button">
      </form>
    </div>
  </body>

</html>