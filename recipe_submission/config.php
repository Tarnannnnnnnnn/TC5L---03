<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // default XAMPP MySQL username
$password = ""; // default XAMPP MySQL password is blank
$dbname = "recipe_database";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
