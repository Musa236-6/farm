<?php
session_start();
include 'db_config.php';

// Redirect if not logged in
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "Product ID missing.";
    exit;
}

$product_id = $_GET['id'];

// Get product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Product not found.";
    exit;
}

$product = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $update_stmt = $conn->prepare("UPDATE products SET name=?, category=?, price=?, quantity=? WHERE id=?");
    $update_stmt->bind_param("ssdii", $name, $category, $price, $quantity, $product_id);

    if ($update_stmt->execute()) {
        echo "<p style='color:lightgreen'>Product updated successfully. <a href='index.php'>Return to Dashboard</a></p>";
    } else {
        echo "<p style='color:red'>Error: " . $update_stmt->error . "</p>";
    }

    $update_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Product</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Update Product</h2>
    <form method="POST" action="">
      <label>Product Name:</label><br>
      <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br><br>

      <label>Category:</label><br>
      <input type="text" name="category" value="<?php echo $product['category']; ?>" required><br><br>

      <label>Price (Ksh):</label><br>
      <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required><br><br>

      <label>Quantity:</label><br>
      <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required><br><br>

      <button type="submit">Update Product</button>
    </form>
    <br>
    <a href="index.php" style="color: yellow;">← Back to Dashboard</a>
  </div>
</body>
</html>
