<?php
session_start(); // Start the session

$servername = "localhost";
$username = "recipes"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "recipes_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Dashboard</title>
    <style>
        /* Global Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            transition: all 0.3s ease;
        }

        body {
            font-family: 'Roboto', sans-serif; /* Modern font */
            background: linear-gradient(135deg, #0f0f0f, #1c1c1c); /* Futuristic gradient background */
            color: #e0e0e0; /* Light grey text for better readability */
            line-height: 1.6;
            overflow-x: hidden;
        }

        header {
            background: rgba(0, 0, 0, 0.9); /* Slight transparency for header */
            color: #e0e0e0;
            padding: 20px 5%;
            text-align: center;
            border-bottom: 5px solid #ff6600; /* Peach border */
            box-shadow: 0 0 20px rgba(255, 102, 0, 0.5); /* Peach glow */
        }

        header h1 {
            font-size: 3em;
            margin-bottom: 10px;
            text-shadow: 0 0 15px rgba(255, 102, 0, 0.7); /* Glowing text effect */
        }

        .logo {
            max-width: 150px;
            margin-bottom: 20px;
            border-radius: 50%; /* Circular logo */
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.5); /* Peach shadow */
        }

        nav {
            background: rgba(34, 34, 34, 0.9); /* Dark grey with slight transparency */
            border-radius: 8px;
            margin: 0 auto;
            width: fit-content;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: #ff6600; /* Peach color */
            text-decoration: none;
            font-weight: 500;
            font-size: 1.2em;
            padding: 15px 25px;
            display: inline-block;
            position: relative;
            border-radius: 5px; /* Rounded corners */
        }

        nav ul li a:hover {
            background: rgba(255, 102, 0, 0.2); /* Subtle peach background on hover */
            color: #fff;
        }

        nav ul li a::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #ff6600;
            transition: width 0.4s ease;
        }

        nav ul li a:hover::before {
            width: 100%;
        }

        .auth-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .auth-link {
            color: #ff6600;
            text-decoration: none;
            font-weight: bold;
            margin-left: 20px;
            padding: 10px 15px;
            border: 1px solid #ff6600;
            border-radius: 5px;
        }

        .auth-link:hover {
            background-color: #ff6600;
            color: #fff;
        }
        main {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(28, 28, 28, 0.9); /* Darker background with slight transparency */
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .recipe {
            background: rgba(255, 255, 255, 0.1); /* Slightly transparent background */
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(255, 102, 0, 0.5);
            margin-bottom: 30px;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .recipe:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(255, 102, 0, 0.7);
        }

        .recipe h3 {
            font-size: 2em;
            margin-bottom: 10px;
            color: #ff6600;
            text-shadow: 0 0 15px rgba(255, 102, 0, 0.7); /* Enhanced glowing text effect */
        }

        .recipe p {
            margin-bottom: 10px;
            color: #e0e0e0; /* Light grey text for readability */
        }

        .recipe img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Subtle shadow for images */
        }

        .recipe a {
            background: linear-gradient(45deg, #ff6600, #e65c00); /* Gradient button */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(255, 102, 0, 0.5);
        }

        .recipe a:hover {
            background: linear-gradient(45deg, #e65c00, #ff9933); /* Gradient button on hover */
            box-shadow: 0 6px 15px rgba(255, 153, 51, 0.5);
        }

        footer {
            background: rgba(0, 0, 0, 0.9);
            color: #e0e0e0;
            text-align: center;
            padding: 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 5px solid #ff6600;
            box-shadow: 0 4px 12px rgba(255, 102, 0, 0.5);
        }

        .submit-button {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(45deg, #ff6600, #e65c00); /* Gradient button */
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(255, 102, 0, 0.5);
            transition: transform 0.3s, background-color 0.3s;
        }

        .submit-button:hover {
            background: linear-gradient(45deg, #e65c00, #ff9933);
            transform: translateY(-5px);
        }

        .toggle-theme {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ff6600; /* Peach background */
            color: white;
            padding: 10px 15px;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(255, 102, 0, 0.5);
            font-size: 1.5em;
            text-align: center;
        }

        @media (max-width: 768px) {
            header h1 {
                font-size: 2em;
            }

            nav ul {
                flex-direction: column;
                width: 100%;
            }

            nav ul li {
                margin: 0;
            }

            nav ul li a {
                padding: 10px;
                font-size: 1em;
            }

            .recipe h3 {
                font-size: 1.5em;
            }
        }
        

        /* Light Mode Styles */
        .light-mode {
            background: linear-gradient(135deg, #f0f0f0, #ffffff); /* Light gradient background */
            color: #333; /* Dark text for better readability */
        }

        .light-mode header {
            background: rgba(255, 255, 255, 0.9); /* Light header background */
            color: #333; /* Dark text in header */
            border-bottom: 5px solid #ff6600; /* Peach border */
            box-shadow: 0 0 20px rgba(255, 102, 0, 0.3); /* Peach glow */
        }

        .light-mode nav ul li a {
            color: #ff6600; /* Peach color for nav links */
        }

        .light-mode nav ul li a:hover {
            background: rgba(255, 102, 0, 0.2); /* Subtle peach background on hover */
        }

        .light-mode footer {
            background: rgba(255, 255, 255, 0.9); /* Light footer background */
            color: #333; /* Dark text in footer */
            border-top: 5px solid #ff6600; /* Peach border */
            box-shadow: 0 4px 12px rgba(255, 102, 0, 0.3); /* Peach shadow */
        }
    </style>
</head>
<body>
    <header>
        <img src="https://dcassetcdn.com/design_img/10150/22996/22996_297698_10150_image.jpg" alt="Logo" class="logo">
        <h1>Recipe Dashboard</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="submit_recipe.php">Submit Recipe</a></li>
                <li><a href="search.php">Browse Recipes</a></li>
                <li><a href="favorites.php">Favorites</a></li>
                <li><a href="aboutus.html">About Us</a></li>
                
            </ul>
        </nav>
        <div class="auth-buttons">
        <a href="register.php" class="auth-link">Register</a>
        <a href="login.php" class="auth-link">Log In</a>
    </div>

    </header>

    <main>
        <section>
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!</h2>
            <h3>All Recipes</h3>
            <?php
            // Fetch all recipes from the database
            $sql = "SELECT * FROM recipes ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Loop through each recipe and display
                while ($row = $result->fetch_assoc()) {
                    $recipe_id = $row['id'];
                    echo "<div class='recipe'>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    echo "<p><strong>Ingredients:</strong> " . htmlspecialchars($row['ingredients']) . "</p>";
                    echo "<p><strong>Preparation:</strong> " . htmlspecialchars($row['preparation']) . "</p>";
                    if (!empty($row['image'])) {
                        echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['title']) . " Image'>";
                    }

                    // Fetch comments for the current recipe
                    $comment_sql = "SELECT * FROM comments WHERE recipe_id = $recipe_id ORDER BY id DESC";
                    $comment_result = $conn->query($comment_sql);

                    if ($comment_result->num_rows > 0) {
                        echo "<div class='comments'>";
                        while ($comment = $comment_result->fetch_assoc()) {
                            echo "<div class='comment'>";
                            echo "<p><strong>" . htmlspecialchars($_SESSION['username']) . ":</strong> " . htmlspecialchars($comment['content']) . "</p>";
                            echo "</div>";
                        }
                        echo "</div>";
                    } else {
                        echo "<p>No comments yet.</p>";
                    }

                    // Comment form
                    echo "<form action='add_comments.php' method='post'>";
                    echo "<input type='hidden' name='recipe_id' value='" . htmlspecialchars($recipe_id) . "'>";
                    echo "<textarea name='comment' rows='3' placeholder='Add a comment...' required></textarea>";
                    echo "<button type='submit' class='submit-button'>Submit</button>";
                    echo "</form>";

                    echo "</div>";
                }
            } else {
                echo "<p>No recipes found.</p>";
            }
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Recipe Sharing Platform</p>
    </footer>

    <script>
        // JavaScript code to toggle light and dark mode
        const toggleTheme = document.querySelector('.toggle-theme');
        const body = document.body;

        toggleTheme.addEventListener('click', () => {
            body.classList.toggle('light-mode');
            const isLightMode = body.classList.contains('light-mode');
            localStorage.setItem('theme', isLightMode ? 'light' : 'dark');
        });

        // Check local storage for theme preference
        document.addEventListener('DOMContentLoaded', () => {
            const theme = localStorage.getItem('theme');
            if (theme === 'light') {
                body.classList.add('light-mode');
            }
        });
    </script>
</body>
</html>