<?php
session_start(); // Start session if not already started

if(isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    // Retrieve product details from the database
    include 'db_connection.php'; // Assuming you have a file named 'db_connection.php' to establish database connection

    $sql = "SELECT * FROM haircare WHERE ID = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $product = [
            'id' => $row['ID'],
            'name' => $row['Name'],
            'price' => $row['Price']
            // Add other necessary product details here
        ];

        // Add product to cart session variable
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        array_push($_SESSION['cart'], $product);

        echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
