<?php
session_start();
include 'config.php';

$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

$sql = "SELECT * FROM recipes WHERE title LIKE '%$search_query%' OR ingredients LIKE '%$search_query%'";
$result = $conn->query($sql);

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Recipes</title>
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

        /* Search Form */
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ff6600; /* Orange border */
            border-radius: 5px 0 0 5px;
            background-color: #222222; /* Darker input background */
            color: #e0e0e0; /* Light text color */
            font-size: 16px;
            width: 300px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #ff6600; /* Orange color */
            color: white;
            border: 1px solid #ff6600;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #e65c00; /* Darker orange */
            transform: translateY(-2px);
        }

        button[type="submit"]:active {
            transform: translateY(1px);
        }

        /* Recipe Container */
        .recipe {
            max-width: 800px;
            margin: 20px auto;
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

        /* Favorite Buttons */
        .recipe form {
            margin-top: 10px;
        }

        .recipe button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff6600; /* Orange color */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .recipe button:hover {
            background-color: #e65c00; /* Darker orange */
            transform: translateY(-2px);
        }

        .recipe button:active {
            transform: translateY(1px);
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
    <h2>Search Recipes</h2>
    <form method="get">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search recipes">
        <button type="submit">Search</button>
    </form>

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

            if ($user_id) {
                // Check if the recipe is already in favorites
                $favorite_sql = "SELECT * FROM favorites WHERE user_id='$user_id' AND recipe_id='" . $row['id'] . "'";
                $favorite_result = $conn->query($favorite_sql);
                $is_favorite = $favorite_result->num_rows > 0;

                if ($is_favorite) {
                    echo "<form method='post' action='remove_favorite.php'>
                            <input type='hidden' name='recipe_id' value='" . $row['id'] . "'>
                            <button type='submit'>Remove from Favorites</button>
                          </form>";
                } else {
                    echo "<form method='post' action='add_favorite.php'>
                            <input type='hidden' name='recipe_id' value='" . $row['id'] . "'>
                            <button type='submit'>Add to Favorites</button>
                          </form>";
                }
            }

            echo "</div>";
        }
    } else {
        echo "<p class='no-recipes'>No recipes found</p>";
    }
    ?>
</body>
</html>
