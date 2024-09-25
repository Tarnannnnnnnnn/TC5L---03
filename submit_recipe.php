

<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $preparation = $_POST['preparation'];

    // Create the 'uploads' directory if it doesn't exist
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target = $upload_dir . basename($image);
        
        // Upload the image and provide feedback
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Image uploaded successfully!";
        } else {
            echo "Failed to upload image.";
        }
    }

    // Insert the recipe into the database
    $sql = "INSERT INTO recipes (user_id, title, ingredients, preparation, image)
            VALUES ('$user_id', '$title', '$ingredients', '$preparation', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "Recipe submitted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Recipe</title>
    <style>
        /* Global Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #1c1c1c; /* Dark background */
            color: #e0e0e0; /* Light text color */
            line-height: 1.6;
            position: relative; /* For positioning the back button */
        }

        /* Back Button */
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #ff6600; /* Orange color */
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
            background-color: #e65c00; /* Darker orange */
            transform: translateY(-2px);
        }

        .back-button:active {
            transform: translateY(1px);
        }

        /* Page Title */
        h2 {
            text-align: center;
            color: #ff6600; /* Orange color */
            margin: 20px 0;


font-size: 2em;
            text-shadow: 0 0 10px rgba(255, 102, 0, 0.7); /* Glowing effect */
        }

        /* Form Container */
        form {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #333333; /* Dark grey background */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #e0e0e0; /* Light text color */
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ff6600; /* Orange border */
            border-radius: 5px;
            background-color: #222222; /* Slightly lighter dark background */
            color: #e0e0e0; /* Light text color */
            font-size: 16px;
        }

        textarea {
            height: 150px;
            resize: vertical;
        }

        /* Button */
        button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #ff6600; /* Orange color */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #e65c00; /* Darker orange */
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(1px);
        }

    </style>
</head>
<body>
    <a href="dashboard.php" class="back-button">Back</a>
    <h2>Submit Recipe</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="title">Recipe Title:</label>
        <input type="text" id="title" name="title" required>
        <label for="ingredients">Ingredients:</label>
        <textarea id="ingredients" name="ingredients" required></textarea>
        <label for="preparation">Preparation Steps:</label>
        <textarea id="preparation" name="preparation" required></textarea>
        <label for="image">Image (optional):</label>
        <input type="file" id="image" name="image">
        <button type="submit">Submit Recipe</button>
    </form>
</body>
</html>
