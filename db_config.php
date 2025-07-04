<?php
$servername = "localhost";
$username = "root"; // Change if you use a different username
$password = "";     // Change if your MySQL has a password
$dbname = "musa_db"; // Make sure this database exists

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
