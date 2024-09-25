<?php
$servername = "localhost";
$username = "recipes"; // default XAMPP username
$password = ""; // default XAMPP password
$dbname = "recipes_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
$recipe_id = intval($_POST['recipe_id']);
$comment = $conn->real_escape_string($_POST['comment']);
$username = $conn->real_escape_string($_POST['username']); 

// Insert comment
$sql = "INSERT INTO comments (recipe_id, username, content) VALUES ('$recipe_id', '$username', '$comment')";

if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php"); // Redirect back to the dashboard
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
