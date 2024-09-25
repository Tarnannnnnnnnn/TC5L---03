<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Sharing Platform</title>
    <style>
/* Global Styles */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(135deg, #0f0f0f, #1c1c1c); /* Dark gradient background */
    color: #e0e0e0;
    line-height: 1.6;
}

/* Header */
header {
    background: linear-gradient(90deg, #ff6600, #ff9933); /* Orange gradient */
    color: white;
    padding: 20px 5%;
    text-align: center;
    border-bottom: 5px solid #e65c00; /* Darker orange bottom border */
}

header h1 {
    font-size: 2.5em;
    margin-bottom: 10px;
    text-shadow: 0 0 10px rgba(255, 102, 0, 0.7); /* Glowing text effect */
}

/* Navigation */
nav {
    background: rgba(0, 0, 0, 0.2); /* Dark background for nav */
    border-radius: 8px;
    margin: 20px auto;
    width: fit-content;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
}

nav ul li {
    margin-right: 15px;
}

nav ul li a {
    color: #000; /* Black color for text */
    text-decoration: none;
    font-weight: bold;
    font-size: 1.1em;
    padding: 15px 20px;
    display: inline-block;
    transition: color 0.3s, background-color 0.3s, transform 0.3s;
}

nav ul li a:hover {
    background-color: #ffe5cc; /* Light orange background */
    color: #e65c00; /* Darker orange */
    border-radius: 4px;
    transform: scale(1.05); /* Slightly enlarge on hover */
}

/* Main Content */
main {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: rgba(28, 28, 28, 0.8); /* Dark background for main */
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

section {
    padding: 20px;
}

section h2 {
    color: #ff6600; /* Orange color */
    margin-bottom: 20px;
    text-shadow: 0 0 10px rgba(255, 102, 0, 0.7); /* Glowing text effect */
}

/* Recipe Cards */
.recipe {
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 15px;
    background: rgba(28, 28, 28, 0.8); /* Dark background for recipe cards */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for pop effect */
}

.recipe h3 {
    font-size: 1.8em;
    margin-bottom: 10px;
    color: #ff6600; /* Orange color */
    text-shadow: 0 0 10px rgba(255, 102, 0, 0.7); /* Glowing text effect */
}

.recipe p {
    margin-bottom: 10px;
    color: #e0e0e0;
}

.recipe img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
    border-radius: 10px;
}

.recipe a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ff6600; /* Orange color */
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.3s;
}

.recipe a:hover {
    background-color: #e65c00; /* Darker orange */
    transform: translateY(-2px);
}

/* Footer */
footer {
    background: linear-gradient(90deg, #ff6600, #ff9933); /* Orange gradient */
    color: white;
    text-align: center;
    padding: 20px;
    position: fixed;
    bottom: 0;
    width: 100%;
    border-top: 5px solid #e65c00; /* Darker orange top border */
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
}

/* Responsive Styles */
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

    .recipe {
        padding: 15px;
    }

    .recipe h3 {
        font-size: 1.5em;
    }
}

@media (max-width: 480px) {
    .recipe {
        padding: 10px;
    }

    .recipe h3 {
        font-size: 1.2em;
    }

    .recipe p {
        font-size: 0.9em;
    }
}

    </style>
</head>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navLinks = document.querySelectorAll('nav ul li a');
        const recipeCards = document.querySelectorAll('.recipe'); // Get all recipe cards
        
        navLinks.forEach(link => {
            link.addEventListener('mouseover', function() {
                this.style.transform = 'scale(1.1)'; // Slightly enlarge the link
                this.style.color = '#e65c00'; // Change text color on hover
            });

            link.addEventListener('mouseout', function() {
                this.style.transform = 'scale(1)'; // Reset scale
                this.style.color = '#000'; // Reset text color
            });
        });

        // Add mouseover and mouseout event listeners to the recipe cards for the pop effect
        recipeCards.forEach(card => {
            card.addEventListener('mouseover', function() {
                this.style.transform = 'scale(1.05)'; // Slightly enlarge the card
                this.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.5)'; // Add deeper shadow
            });

            card.addEventListener('mouseout', function() {
                this.style.transform = 'scale(1)'; // Reset card size
                this.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.3)'; // Reset shadow
            });
        });
    });
</script>

<body>
    <header>
        <h1>Recipe Sharing Platform</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="submit_recipe.php">Submit a Recipe</a></li>
                <li><a href="search.php">Browse Recipes</a></li>
                <li><a href="favorites.php">Favorites</a></li>
                <li><a href="aboutus.html">About Us</a></li>
                <li><a href="logout.php">Log Out</a></li>

            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>All Recipes</h2>
            <?php
            include('config.php');
            
            // SQL query to fetch all recipes
            $sql = "SELECT * FROM recipes ORDER BY ingredients DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Loop through each recipe and display the details
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='recipe'>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    echo "<p><strong>Ingredients:</strong> " . htmlspecialchars($row['ingredients']) . "</p>";
                    echo "<p><strong>Preparation:</strong> " . htmlspecialchars($row['preparation']) . "</p>";
                    // Display recipe image if available
                    if (!empty($row['image'])) {
                        echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['title']) . " Image'>";
                    }
                  
                }
            } else {
                echo "<p>No recipes available yet.</p>";
            }

            $conn->close();
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Recipe Sharing Platform. All Rights Reserved.</p>
    </footer>
</body>
</html>
