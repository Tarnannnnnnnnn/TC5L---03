<?php
// Start the session
session_start();

// Include your database connection file
include('config.php');

// Initialize an error message variable
$error_msg = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the form data
    if (!empty($username) && !empty($password)) {
        // Query to check if the user exists
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables for logged-in user
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect to the homepage (index.php)
                header("Location: index.php");
                exit();
            } else {
                // If password is incorrect
                $error_msg = "Invalid password. Please try again.";
            }
        } else {
            // If user doesn't exist
            $error_msg = "User not found. Please try again.";
        }
    } else {
        $error_msg = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Recipe Sharing Platform</title>
    <style>
        /* General Reset */
* { 
    box-sizing: border-box; 
    margin: 0; 
    padding: 0; 
}

/* Body */
body { 
    font-family: 'Roboto', sans-serif; 
    background: linear-gradient(135deg, #0f0f0f, #1c1c1c); /* Dark gradient background */
    color: #e0e0e0; 
    display: flex;
    flex-direction: column; /* Stack elements vertically */
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Header Section */
header { 
    background-color: #ff6600; /* Peach color */
    color: white; 
    padding: 20px; 
    text-align: center; 
    width: 100%;
}

header h1 { 
    font-size: 2.5em; 
    text-shadow: 0 0 10px rgba(255, 102, 0, 0.7); /* Glowing text effect */
}

/* Form Container */
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
    width: 100%;
}

/* Form Styles */
form { 
    max-width: 400px; 
    margin: 0 auto; 
    padding: 40px; 
    background: rgba(28, 28, 28, 0.8); /* Dark background for form */
    border-radius: 15px; 
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* Shadow effect */
    text-align: center;
}

form h2 { 
    margin-bottom: 20px; 
    color: #ff6600; /* Peach color */
    text-shadow: 0 0 10px rgba(255, 102, 0, 0.7); /* Glowing text effect */
}

form label { 
    display: block; 
    margin-bottom: 10px; 
    font-weight: bold; 
    color: #e0e0e0; 
}

input[type="text"], 
input[type="password"] { 
    width: calc(100% - 20px); 
    padding: 10px; 
    margin-bottom: 15px; 
    border: 1px solid #ff6600; /* Peach border */
    border-radius: 5px; 
    background: rgba(0, 0, 0, 0.2); 
    color: #e0e0e0; 
    font-size: 16px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Input shadow */
    transition: border-color 0.3s, background-color 0.3s;
}

input[type="text"]:focus, 
input[type="password"]:focus { 
    border-color: #ff9933; /* Lighter peach on focus */
    background: rgba(0, 0, 0, 0.4); 
    outline: none;
}

/* Password Toggle Icon */
.password-container {
    position: relative;
    width: 100%;
}

.password-container input[type="password"] {
    padding-right: 40px;
}

.eye-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 20px;
    color: #e0e0e0;
}

/* Button */
button { 
    display: block; 
    width: 100%; 
    padding: 12px; 
    background: linear-gradient(45deg, #ff6600, #e65c00); /* Gradient button */
    color: white; 
    border: none; 
    border-radius: 5px; 
    font-size: 1.1em; 
    cursor: pointer; 
    box-shadow: 0 4px 10px rgba(255, 102, 0, 0.5); 
    transition: background 0.3s, transform 0.3s; 
}

button:hover { 
    background: linear-gradient(45deg, #e65c00, #ff9933); /* Lighter gradient on hover */
    transform: translateY(-2px);
}

button:active { 
    transform: translateY(1px); 
}

/* Links and Error Messages */
form p {
    margin-top: 20px;
    font-size: 14px;
}

form a {
    color: #ff6600; /* Peach color */
    text-decoration: none;
}

form a:hover {
    text-decoration: underline;
}

.error {
    color: #ff0000; /* Red for error */
    margin-bottom: 15px;
    font-weight: bold;
}

    </style>
</head>
<body>

    <header>
        <h1>Login</h1>
    </header>

    <div class="login-container">
        <form action="" method="POST">
            <h2>Login to Your Account</h2>

            <!-- Display error message if login fails -->
            <?php if (!empty($error_msg)): ?>
                <p class="error"><?php echo htmlspecialchars($error_msg); ?></p>
            <?php endif; ?>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <div class="password-container">
                <label for="password">Password:</label>
                <input id="password" name="password" type="password" required>
                <span id="togglePassword" class="eye-icon">👁️</span>
            </div>

            <button type="submit">Login</button>

            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;

            // Toggle the eye icon
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>

</body>
</html>