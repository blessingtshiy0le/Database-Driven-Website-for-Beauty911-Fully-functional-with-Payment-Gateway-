<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];

    // Delete product from the database
    $sql = "DELETE FROM products WHERE id='$productId'";
    
    if (mysqli_query($conn, $sql)) {
        echo "Product deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}
?>
