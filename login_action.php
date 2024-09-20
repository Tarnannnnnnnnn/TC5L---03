<?php
session_start(); // Start session

include 'config.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevent SQL Injection
    $username = mysqli_real_escape_string($conn, $username);
    
    // Check if the username exists in the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Store user information in session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // Redirect to index.php after successful login
            header(header: "Location: index.php");
            exit(); // Stop script execution after redirection
        } else {
            // If password doesn't match
            echo "Invalid password!";
        }
    } else {
        // If username not found
        echo "User not found!";
    }
}
?>
