<?php
include 'config.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Registration successful!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $conn->error;
    }

    // Return the response as JSON
    echo json_encode($response);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Global Styles */
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
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative; /* For positioning the back button */
        }

        /* Back Button */
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #ff6600; /* Orange background */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .back-button:hover {
            background-color: #e65c00; /* Darker orange on hover */
            transform: translateY(-2px);
        }

        .back-button:active {
            transform: translateY(1px);
        }

        /* Form Container */
        form {
            max-width: 400px;
            width: 100%;
            padding: 40px;
            background: rgba(28, 28, 28, 0.8); /* Dark background for form */
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* Shadow effect */
            text-align: center;
        }

        form h2 {
            margin-bottom: 20px;
            color: #ff6600; /* Orange accent */
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
            border: 1px solid #ff6600; /* Orange border */
            border-radius: 5px;
            background: rgba(0, 0, 0, 0.2);
            color: #e0e0e0;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Input shadow */
            transition: border-color 0.3s, background-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #ff9933; /* Lighter orange on focus */
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
            color: #ff6600; /* Orange accent */
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

        /* Modal Pop-out Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            background: rgba(28, 28, 28, 0.9); /* Dark background */
            padding: 20px;
            width: 300px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        .modal h3 {
            color: white; /* White color for registration success message */
            margin-bottom: 20px;
        }

        .modal button {
            padding: 10px 20px;
            background: #ff6600;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <a href="index.php" class="back-button">Back</a>
    <div class="form-container">
        <form method="post" id="registerForm">
            <h2>Register</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <span class="eye-icon" id="togglePassword">&#128065;</span> <!-- Eye Icon -->
            </div>
            <button type="submit">Register</button>
            <div id="responseMessage" class="message"></div>
        </form>
    </div>

    <!-- Modal Pop-out -->
    <div id="modal" class="modal">
        <h3 id="modalMessage">Registration successful!</h3>
        <button id="closeModal">OK</button>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈'; // Toggle between eye and hidden icon
        });

        // Handle form submission with AJAX
        document.getElementById('registerForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            var formData = new FormData(this);

            // Send AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'register.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    // Show modal pop-out with success or error message
                    var modal = document.getElementById('modal');
                    var modalMessage = document.getElementById('modalMessage');

                    if (response.status === 'success') {
                        modalMessage.textContent = response.message; // Set the success message
                    } else {
                        modalMessage.textContent = response.message; // Set the error message
                    }

                    // Display the modal
                    modal.style.display = 'block';
                }
            };
            xhr.send(formData);
        });

        // Close Modal
        document.getElementById('closeModal').addEventListener('click', function () {
            document.getElementById('modal').style.display = 'none'; // Hide modal when clicking "OK"
        });
    </script>
</body>

</html>
