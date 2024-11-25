<?php
// Start session
session_start();

// Include database connection file
include_once 'db_connection.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the required variables are set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (not needed in this context as it's already stored in database)
    // These were processed in process_order.php and stored in the database
    // $name = htmlspecialchars($_POST["name"]);
    // $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    // $booking_datetime = $_POST["booking_datetime"];

    // Assuming the email and booking_datetime are passed as GET parameters from a secure source
    // (This example assumes they are passed securely. In production, ensure security measures.)

    // Retrieve order details from database
    if (isset($_GET['email']) && isset($_GET['booking_datetime'])) {
        $email = $_GET['email'];
        $booking_datetime = $_GET['booking_datetime'];

        // Query to retrieve order details
        $stmt = $conn->prepare("SELECT name, email, booking_datetime, total_amount FROM payments WHERE email = ? AND booking_datetime = ?");
        $stmt->bind_param("ss", $email, $booking_datetime);
        $stmt->execute();
        $stmt->store_result();

        // Bind result variables
        $stmt->bind_result($name, $email, $booking_datetime, $totalPrice);

        // Fetch the order details
        if ($stmt->fetch()) {
            // Calculate the upfront payment (50% of the total price)
            $upfrontPayment = $totalPrice / 2;

            // Close statement
            $stmt->close();
        } else {
            // No records found (handle this scenario as per your application's logic)
            echo "<p>No order details found.</p>";
            exit; // Stop further execution if no details are found
        }
    } else {
        // Missing parameters (handle this scenario as per your application's logic)
        echo "<p>Missing parameters.</p>";
        exit; // Stop further execution if parameters are missing
    }

    // Clear the cart after successful payment (not needed in this context as we're displaying order details)
    // unset($_SESSION['cart']);
} else {
    // Redirect user to index.html if accessed directly without POST request (optional security measure)
    header('Location: index.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <style>
        /* Additional styles for order confirmation page */
        body, html {
            height: 100%;
            margin: 0;
            background-color: #fee3ec; /* Pink background color */
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Use min-height to ensure it takes at least the full viewport height */
            overflow-y: auto; /* Add vertical scrollbar when content exceeds container height */
            background-color: #fee3ec; /* Pink background color */
        }

        form {
            width: 90%;
            max-width: 600px;
            border: 1px solid #000;
            padding: 20px;
            background-color: #fff; /* White form background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-bottom: 20px; /* Add margin to ensure bottom edge is visible */
            overflow: auto; /* Add scrollbar when content exceeds the form height */
        }

        form h2 {
            text-align: center;
            text-decoration: underline; /* Underline "Your Order Details" */
            margin-bottom: 20px;
        }

        form p {
            margin-bottom: 10px;
        }

        .instruction {
            margin-top: 20px;
        }

        .back-button {
            width: 50%; /* Narrower width for the button */
            padding: 10px;
            background-color: #fee3ec;
            color: #000;
            text-decoration: none;
            border: 1px solid #000;
            border-radius: 5px;
            display: inline-block;
            text-align: center;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <form method="post">
        <h2>Your Order Details</h2>

        <?php
        // Display retrieved order details
        if (isset($name) && isset($email) && isset($booking_datetime) && isset($totalPrice)) {
            echo "<p><strong>Name:</strong> {$name}</p>";
            echo "<p><strong>Email:</strong> {$email}</p>";
            echo "<p><strong>Booking Date and Time:</strong> {$booking_datetime}</p>";
            echo "<p><strong>Total Amount:</strong> R {$totalPrice}</p>";
            echo "<p><strong>Upfront Payment (50%):</strong> R {$upfrontPayment}</p>";
            
            // Assuming you also need to display ordered items (retrieve from session cart if needed)
            if (!empty($_SESSION['cart'])) {
                echo "<p><strong>Ordered Items:</strong></p><ul>";
                foreach ($_SESSION['cart'] as $item) {
                    echo "<li>{$item['name']} - R {$item['price']}</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No ordered items found.</p>";
            }
        } else {
            echo "<p>Order details are missing. Please try again.</p>";
        }
        ?>

        <div class="instruction">
            <h3>Order Confirmation Instructions</h3>
            <p>1. Please take note that your payment was only 50% of the total price to secure your booking.</p>
            <p>2. The remaining 50% is paid upon completion of the purchased service.</p>
            <p>3. Your order receipt has also been emailed to you.</p>
            <p>4. Please have this with you when you come for your service.</p>
        </div>

        <!-- Back button to navigate back to the index.html -->
        <a href="index.html" class="back-button">Back to Home</a>
    </form>
</div>

</body>
</html>
