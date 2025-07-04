<?php
session_start();
include 'db_config.php';

// Redirect if not logged in
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit;
}

// Check if ID is passed
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete the product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        header("Location: index.php?deleted=1");
        exit;
    } else {
        echo "Error deleting product.";
    }

    $stmt->close();
} else {
    echo "No product ID provided.";
}
?>
