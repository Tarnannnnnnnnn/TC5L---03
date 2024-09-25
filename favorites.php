<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT recipes.* FROM recipes
        JOIN favorites ON recipes.id = favorites.recipe_id
        WHERE favorites.user_id = '$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Favorites</title>
    <link rel="stylesheet" href="styles.css">
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
            position: relative; /* For positioning elements */
            overflow: hidden; /* Prevent scrolling of body */
            display: flex; /* Use flexbox to center the title vertically */
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center items horizontally */
            justify-content: flex-start; /* Align items to the top */
            height: 100vh; /* Full viewport height */
        }

        /* Back Button */
        .back-button {
            position: absolute; /* Absolute positioning */
            top: 20px; /* Distance from the top */
            left: 20px; /* Distance from the left */
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
            margin: 40px 0; /* Space above and below the title */
            font-size: 2em;
            text-shadow: 0 0 10px rgba(255, 102, 0, 0.7); /* Glowing effect */
            flex-shrink: 0; /* Prevent title from shrinking */
        }

        /* Recipe Container */
        .recipe-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            overflow-y: auto; /* Allow vertical scrolling for recipes */
            height: calc(100vh - 100px); /* Full height minus space for title and button */
        }

        .recipe {
            margin: 20px 0;
            padding: 20px;
            background-color: #333333; /* Dark grey background */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .recipe h3 {
            font-size: 1.8em;
            margin-bottom: 10px;
            color: #ff6600; /* Orange color */
        }

        .recipe p {
            margin-bottom: 10px;
            color: #e0e0e0; /* Light text color */
        }

        .recipe img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        /* No Recipes Found */
        .no-recipes {
            text-align: center;
            color: #e0e0e0; /* Light text color */
            font-size: 1.2em;
            margin: 20px;
        }
    </style>
</head>
<body>
    <a href="dashboard.php" class="back-button">Back</a>
    <h2>My Favorite Recipes</h2>

    <div class="recipe-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='recipe'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['ingredients']) . "</p>";
                echo "<p>" . htmlspecialchars($row['preparation']) . "</p>";
                if ($row['image']) {
                    echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Recipe Image'>";
                }
                echo "</div>";
            }
        } else {
            echo "<p class='no-recipes'>No favorite recipes found</p>";
        }
        ?>
    </div>
</body>
</html>
