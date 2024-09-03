<?php
session_start();

// Database configuration
$servername = "localhost";
$dbUsername = "root"; // Default username for XAMPP
$dbPassword = ""; // Default password for XAMPP is empty
$dbname = "login_system"; // Your database name

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Query to fetch user from database
    $sql = "SELECT * FROM users WHERE username = '$inputUsername' AND password = md5('$inputPassword')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, start a session
        $_SESSION['username'] = $inputUsername;
        echo "Login successful! Welcome, " . $inputUsername;
        // Redirect to the dashboard or another page
        header("Location: dashboard.php"); // Replace 'dashboard.php' with your desired page
        exit;
    } else {
        // Invalid credentials
        echo "Invalid username or password.";
    }
}

$conn->close();
?>
