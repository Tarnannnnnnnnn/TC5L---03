<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "recipes_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $recipeName = $conn->real_escape_string($_POST['recipeName']);
    $ingredients = $conn->real_escape_string($_POST['ingredients']);
    $preparationSteps = $conn->real_escape_string($_POST['preparationSteps']);
    $imagePath = '';

    // Handle file upload
    if (isset($_FILES['recipeImage']) && $_FILES['recipeImage']['error'] === UPLOAD_ERR_OK) {
        $imagePath = 'uploads/' . basename($_FILES['recipeImage']['name']);
        move_uploaded_file($_FILES['recipeImage']['tmp_name'], $imagePath);
    }

    // Insert recipe into database
    $sql = "INSERT INTO recipes (recipe_name, ingredients, preparation_steps, image_path)
            VALUES ('$recipeName', '$ingredients', '$preparationSteps', '$imagePath')";

    if ($conn->query($sql) === TRUE) {
        echo "Recipe submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
