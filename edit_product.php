<?php
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"]; // Optional field

    $sql = "UPDATE products SET name=?, price=?, description=? WHERE id=?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sdsi", $name, $price, $description, $id);
        if ($stmt->execute()) {
            header("Location: manage_products.php");
            exit();
        } else {
            echo "Error: " . $mysqli->error;
        }
        $stmt->close();
    }
    $mysqli->close();
}
?>
