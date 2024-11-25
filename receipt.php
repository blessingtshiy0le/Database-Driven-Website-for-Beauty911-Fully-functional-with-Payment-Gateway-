<?php
session_start();

$order_details = isset($_SESSION['order_details']) ? $_SESSION['order_details'] : [];
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$totalPrice = isset($order_details['amount']) ? $order_details['amount'] : 0; // Retrieve original total amount

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        /* Basic styling for receipt page */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .receipt-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fee3ec;
            padding: 20px;
            border: 1px solid #000;
            border-radius: 5px;
        }
        h1 {
            text-align: center;
        }
        .receipt-details {
            margin-top: 20px;
        }
        .receipt-details h2 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .ordered-items {
            margin-top: 10px;
        }
        .ordered-item {
            margin-bottom: 5px;
        }
        .download-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        /* Style for buttons */
        button {
            padding: 10px 20px;
            background-color: #fee3ec;
            color: #000000;
            border: 1px solid #000;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px; /* Added space */
        }

        button:hover {
            background-color: #ffffff;
        }

        /* Style for the link button */
        .link-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #fee3ec;
            color: #000000;
            border: 1px solid #000;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            margin-top: 10px; /* Added space */
        }

        .link-button:hover {
            background-color: #ffffff;
        }

        /* Additional styles for spacing */
        .section-divider {
            margin: 40px 0;
            border-top: 1px solid #ccc;
        }
        .download-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #fee3ec;
            color: #000000;
            border: 1px solid #000;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            margin-top: 10px; /* Added space */
        }

        .download-link:hover {
            background-color: #ffffff;
        }

    </style>
</head>
<body>
    <div class="receipt-container">
        <h1>Receipt</h1>
        <div class="receipt-details">
            <h2>Client Information</h2>
            <?php if (!empty($order_details)): ?>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($order_details['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($order_details['email']); ?></p>
            <?php else: ?>
                <p>No client information found.</p>
            <?php endif; ?>

            <h2>Booking Date and Time</h2>
            <?php if (!empty($order_details['booking_datetime'])): ?>
                <p><?php echo htmlspecialchars($order_details['booking_datetime']); ?></p>
            <?php else: ?>
                <p>No booking date and time found.</p>
            <?php endif; ?>

            <h2>Ordered Items</h2>
            <?php if (!empty($cart_items)): ?>
                <ul class="ordered-items">
                    <?php foreach ($cart_items as $item): ?>
                        <li class="ordered-item"><?php echo htmlspecialchars($item['name']); ?> - R <?php echo htmlspecialchars($item['price']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No items ordered.</p>
            <?php endif; ?>

            <h2>Order Info</h2>
    <ol>
        <li>Your order total is only 50% of the total price to secure your booking.</li>
        <li>You will be required to pay the other 50% upon service completion.</li>
        <li>Please bring a copy of your receipt along with you to your appointment.</li>
    </ol>

            <p><strong>Total Amount:</strong> R <?php echo number_format($totalPrice, 2); ?></p>
        </div>
        <div class="download-link">
            <a href="download_receipt.php" download>Download Receipt</a>
        </div>
        <a href="index.html" class="link-button">Back To Home</a>
    </div>
</body>
</html>
