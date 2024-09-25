<?php
session_start();
include 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle the favorite submission via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $recipe_id = $_POST['recipe_id'];

    $sql = "INSERT INTO favorites (user_id, recipe_id) VALUES ('$user_id', '$recipe_id')";

    if ($conn->query($sql) === TRUE) {
        // Check if the request is an AJAX request
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // Return a JSON response with a redirect link
            echo json_encode([
                'status' => 'success',
                'message' => 'Recipe added to favorites!',
                'redirect' => 'dashboard.php'
            ]);
        } else {
            // Redirect for regular form submission
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
    exit(); // Ensure no further output is sent
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe to Favorites</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            padding: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #ff6600;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Modal Styles */
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
            color: #ff6600; /* Orange accent */
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
    <div class="container">
        <h1>Add Recipe to Favorites</h1>
        <form id="favoriteForm">
            <input type="hidden" name="recipe_id" value="1"> <!-- Example recipe ID -->
            <button type="submit">Add to Favorites</button>
        </form>
    </div>

    <!-- Modal Pop-out -->
    <div id="modal" class="modal">
        <h3 id="modalMessage"></h3>
        <button id="closeModal">OK</button>
    </div>

    <script>
        // Handle form submission with AJAX
        document.getElementById('favoriteForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            var formData = new FormData(this);

            // Send AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_favorite.php', true); // Explicitly point to 'add_favorite.php'
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); // Set this header for AJAX requests
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    // Show modal pop-out with success or error message
                    var modal = document.getElementById('modal');
                    var modalMessage = document.getElementById('modalMessage');

                    if (response.status === 'success') {
                        modalMessage.textContent = response.message; // Set the success message

                        // Redirect to dashboard after 2 seconds
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000);
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
        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('modal').style.display = 'none'; // Hide modal when clicking "OK"
        });
    </script>
    
</body>
</html>
