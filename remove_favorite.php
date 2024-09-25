<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $recipe_id = $_POST['recipe_id'];

    // Delete the recipe from the favorites table
    $sql = "DELETE FROM favorites WHERE user_id='$user_id' AND recipe_id='$recipe_id'";

    if ($conn->query($sql) === TRUE) {
        // Check if the request is AJAX
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode([
                'status' => 'success',
                'message' => 'Recipe removed from favorites!',
                'redirect' => 'dashboard.php'
            ]);
        } else {
            // Redirect to the dashboard for non-AJAX requests
            header("Location: dashboard.php");
            exit();
        }
    } else {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error: ' . $conn->error
            ]);
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
