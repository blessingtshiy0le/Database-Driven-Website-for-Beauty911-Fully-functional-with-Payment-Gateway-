<?php
session_start();
require_once 'db_connection.php'; // Include your database connection file

if (isset($_SESSION['order_details'])) {
    $name = $_SESSION['order_details']['name'];
    $email = $_SESSION['order_details']['email'];
    $booking_datetime = $_SESSION['order_details']['booking_datetime'];
    $amount = $_SESSION['order_details']['amount'];

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $database);


    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the payment record into the database
    $stmt = $conn->prepare("INSERT INTO payments (name, email, booking_datetime, total_amount, payment_status) VALUES (?, ?, ?, ?, 'Paid')");
    $stmt->bind_param("sssd", $name, $email, $booking_datetime, $amount);

    if ($stmt->execute()) {
        echo "Payment successful!";
        // Clear the cart after successful payment
        unset($_SESSION['cart']);
        // Redirect to the receipt page
        header('Location: receipt.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'No order details found.';
}
?>
