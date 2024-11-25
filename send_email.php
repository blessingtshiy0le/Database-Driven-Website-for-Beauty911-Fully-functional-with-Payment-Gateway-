<?php
session_start();

if (isset($_SESSION['order_details'])) {
    $order_details = $_SESSION['order_details'];

    // Extract order details
    $name = $order_details['name'];
    $email = $order_details['email'];
    $totalPrice = $order_details['total_amount'];
    $orderedItems = $order_details['items'];

    // Construct email message
    $subject = 'Order Confirmation';
    $message = "Hello {$name},\n\n";
    $message .= "Thank you for your order!\n\n";
    $message .= "Here are your order details:\n\n";
    $message .= "Total Amount: R {$totalPrice}\n\n";
    $message .= "Ordered Items:\n";
    foreach ($orderedItems as $item) {
        $message .= "{$item['name']} - R {$item['price']}\n";
    }
    $message .= "\n\nIf you have any questions, please contact us.\n\n";
    $message .= "Best regards,\nYour Store Team";

    // Set headers
    $headers = 'From: beauty911payments@gmail.com' . "\r\n" .
               'Reply-To: beauty911payments@gmail.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Send email
    if (mail($email, $subject, $message, $headers)) {
        echo 'Email sent successfully.';
    } else {
        echo 'Error sending email.';
    }
} else {
    echo 'Order details not found.';
}
?>
