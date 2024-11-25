<?php
session_start();

// Generate the receipt content
// Generate the receipt content
$receipt_content = "Client Name: " . $_SESSION['order_details']['name'] . "\n";
$receipt_content .= "Client Email: " . $_SESSION['order_details']['email'] . "\n";
$receipt_content .= "Booking Date and Time: " . $_SESSION['order_details']['booking_datetime'] . "\n";
$receipt_content .= "Ordered Items:\n";

// Check if cart is set and not empty before iterating
if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $item) {
        $receipt_content .= $item['name'] . " - R " . $item['price'] . "\n";
    }
} else {
    $receipt_content .= "No items ordered.\n";
}


// Calculate total price
// Calculate total price
$totalPrice = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $totalPrice += $item['price'];
    }
}


// Output the total amount in receipt content
$receipt_content .= "Total Amount: R " . number_format($totalPrice, 2) . "\n";

// Set headers for download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="beauty911receipt.txt"');

// Output the receipt content for download
echo $receipt_content;
?>
