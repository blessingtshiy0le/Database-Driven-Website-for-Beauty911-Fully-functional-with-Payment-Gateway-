<?php
session_start();
require_once 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $booking_datetime = $_POST['booking_datetime'];

    $amount_str = $_POST['amount'];
    $amount_str = str_replace('R ', '', $amount_str); 
    $amount = (float) $amount_str; 

    if (empty($name) || !$email || empty($booking_datetime) || $amount <= 0) {
        echo 'Invalid input data.';
        exit;
    }

    $total_amount = $amount; // Use $amount as total_amount

    $sql = "INSERT INTO payments (name, email, booking_datetime, total_amount, payment_status) VALUES (?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssd", $name, $email, $booking_datetime, $total_amount);

    if ($stmt->execute()) {
        $payment_id = $stmt->insert_id;

        $amount_cents = $amount * 100; 
        $currency = 'ZAR';
        $cancelUrl = 'http://localhost/Responsive-Beauty-Salon-or-Spa-Website-HTML-CSS-JavaScript-master/index.html';
        $successUrl = 'http://localhost/Responsive-Beauty-Salon-or-Spa-Website-HTML-CSS-JavaScript-master/receipt.php';
        $failureUrl = 'http://localhost/Responsive-Beauty-Salon-or-Spa-Website-HTML-CSS-JavaScript-master/index.html';

        $secret_key = 'sk_test_b6c90cd7AWr5R4Vfb2b43ab94924';

        $data = [
            'amount' => $amount_cents,
            'currency' => $currency,
            'cancelUrl' => $cancelUrl,
            'successUrl' => $successUrl,
            'failureUrl' => $failureUrl,
        ];

        $ch = curl_init('https://payments.yoco.com/api/checkouts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $secret_key,
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_status == 200) {
            $response_data = json_decode($response, true);
            if (isset($response_data['redirectUrl'])) {
                $_SESSION['order_details'] = [
                    'name' => $name,
                    'email' => $email,
                    'booking_datetime' => $booking_datetime,
                    'amount' => $amount,
                    'payment_id' => $payment_id,
                ];
                header('Location: ' . $response_data['redirectUrl']);
                exit;
            } else {
                echo 'Error creating checkout: ' . $response;
            }
        } else {
            echo 'HTTP request error: ' . $http_status;
        }
    } else {
        echo 'Error saving order details: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request method.';
}
?>
