<?php
session_start();

// Check if index is provided and it's a valid integer
if(isset($_GET['index']) && filter_var($_GET['index'], FILTER_VALIDATE_INT) !== false) {
    $index = $_GET['index'];
    
    // Check if the item exists in the session cart
    if(isset($_SESSION['cart'][$index])) {
        // Remove the item from the session cart
        unset($_SESSION['cart'][$index]);
        // Optional: If you want to re-index the array after removing an item
        // $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>
