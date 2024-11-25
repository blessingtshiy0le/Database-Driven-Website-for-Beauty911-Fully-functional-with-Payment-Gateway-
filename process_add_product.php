<?php
require_once "db_connection.php";

// Check if all required fields are provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"], $_POST["price"])) {
    // Sanitize input data
    $name = trim($_POST["name"]);
    $price = $_POST["price"];

    // Validate input data
    $errors = array();

    if (empty($name)) {
        $errors[] = "Product name is required.";
    }

    if (!is_numeric($price) || $price <= 0) {
        $errors[] = "Price must be a valid numeric value greater than zero.";
    }

    // If there are validation errors, display them and exit
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit;
    }

    // Insert the product into the database
    $sql = "INSERT INTO products (name, price) VALUES (?, ?)";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sd", $name, $price);
        if ($stmt->execute()) {
            header("Location: manage_products.php");
            exit();
        } else {
            echo "Error: " . $mysqli->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }
} else {
    echo "Invalid request.";
}

$mysqli->close();
?>
