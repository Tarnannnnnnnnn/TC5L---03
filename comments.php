<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $recipeId = intval($_POST['recipe_id']);
    $comment = $conn->real_escape_string($_POST['comment']);
    $userId = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Fetch the username (assuming there's a 'users' table)
    $userSql = "SELECT username FROM users WHERE id = $userId";
    $userResult = $conn->query($userSql);
    $username = $userResult->fetch_assoc()['username'];

    // Insert comment into the databa   se
    $sql = "INSERT INTO comments (recipe_id, user_id, username, comment, created_at) VALUES ($recipeId, $userId, '$username', '$comment', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php"); // Redirect to the dashboard or the same page
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "You must be logged in to comment.";
}
?>
