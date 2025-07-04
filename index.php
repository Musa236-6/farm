<?php
session_start();
include 'db_config.php';

// Redirect if not logged in
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Farm Product Dashboard</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <header>
      <h1>Welcome, <?php echo $_SESSION['username']; ?> 👩‍🌾</h1>
      <nav>
        <a href="add_product.php">Add Product</a>
        <a href="logout.php">Logout</a>
      </nav>
    </header>

    <main>
      <h2>Farm Products</h2>

      <?php if ($result->num_rows > 0): ?>
      <table border="1" cellpadding="10" cellspacing="0" style="background-color: white; color: black; margin: auto;">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price (Ksh)</th>
          <th>Quantity</th>
          <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['category']; ?></td>
          <td><?php echo $row['price']; ?></td>
          <td><?php echo $row['quantity']; ?></td>
          <td>
            <a href="update_product.php?id=<?php echo $row['id']; ?>">Edit</a> |
            <a href="delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this product?');">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </table>
      <?php else: ?>
        <p>No products found.</p>
      <?php endif; ?>
    </main>
  </div>
</body>
</html>
