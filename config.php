<?php
$servername = "localhost";
$username = "recipes"; // default XAMPP username
$password = ""; // default XAMPP password
$dbname = "recipes_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>