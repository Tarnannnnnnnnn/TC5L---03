<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the homepage or login page
header("Location: dashboard.php"); // Change this to 'login.php' if you want to redirect to the login page instead
exit();
?>
