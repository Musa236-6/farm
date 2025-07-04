<?php
session_start();
include 'db_config.php';

// Redirect if not logged in
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $staff_id = $_SESSION['staff_id'];

    $stmt = $conn->prepare("INSERT INTO products (name, category, price, quantity, added) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdii", $name, $category, $price, $quantity, $staff_id);

    if ($stmt->execute()) {
        echo "<p style='color:lightgreen'>Product added successfully. <a href='index.php'>View All Products</a></p>";
    } else {
        echo "<p style='color:red'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Add New Farm Product</h2>
    <form method="POST" action="">
      <label>Product Name:</label><br>
      <input type="text" name="name" required><br><br>

      <label>Category:</label><br>
      <input type="text" name="category" required><br><br>

      <label>Price (Ksh):</label><br>
      <input type="number" step="0.01" name="price" required><br><br>

      <label>Quantity:</label><br>
      <input type="number" name="quantity" required><br><br>

      <button type="submit">Add Product</button>
    </form>
    <br>
    <a href="index.php" style="color: yellow;">← Back to Dashboard</a>
  </div>
</body>
</html>
