<?php
// Create a connection to the MySQL database
$conn = new mysqli("localhost", "root", "", "cozycat");

// Stop the script if the database connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Set UTF-8 encoding for proper text support
$conn->set_charset("utf8mb4");
?>