<?php
// webhook.php
$input = file_get_contents('php://input');
$event_json = json_decode($input, true);

if ($event_json['type'] === 'payment.succeeded') {
    $paymentId = $event_json['data']['id'];
    // Update your database or order status here
    // Mark order as paid using $paymentId
} else {
    // Handle other event types
}

http_response_code(200); // Respond with HTTP 200 to acknowledge receipt of the event
?>
