<?php
session_start();
include 'db_connection.php'; // Ensure this file contains your database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']), ENT_QUOTES, 'UTF-8');
    $datetime = htmlspecialchars(trim($_POST['datetime']), ENT_QUOTES, 'UTF-8');

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Prepare and execute the SQL query
    $sql = "INSERT INTO skin_consultation (name, email, phone, date, time) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        error_log('mysqli prepare() failed: ' . htmlspecialchars($conn->error));
        exit('Database error.');
    }

    $stmt->bind_param("sssss", $name, $email, $phone, $datetime, $datetime);
    if ($stmt->execute()) {
        // Redirect to confirmation page on successful booking
        header("Location: confirmation.html");
        exit();
    } else {
        error_log('mysqli execute() failed: ' . htmlspecialchars($stmt->error));
        echo "Error: Could not book the consultation.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book A Skin Consultation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fee3ec;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #000;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #000;
        }
        form {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #000;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="datetime-local"] {
            width: 90%; 
            padding: 10px;
            border: 1px solid #fff;
            border: 1px solid #000;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 94%;
            padding: 10px;
            border: 1px solid #000;
            border-radius: 5px;
            background-color: #fee3ec;
            color: #000;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #fff;
        }
        .back-button {
            width: 20%;
            padding: 10px; 
            border: 1px solid #000;
            border-radius: 5px;
            background-color: #fee3ec;
            color: #000;
            text-decoration: none; /* Remove underline */
            display: inline-block; /* Make it inline-block to respect width */
            margin-top: 10px; /* Add some spacing */
            text-align: center; /* Center text */
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #fff;
        }
    </style>
</head> 
<body>
    
    <div class="container">
        <h1>Book A Skin Consultation</h1>
        <form action="#" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="datetime">Preferred Date and Time:</label>
                <input type="datetime-local" id="datetime" name="datetime" required>
            </div>
            <input type="submit" value="Submit">
        </form>
        <!-- Back button -->
        <div class="back-button-container">
            <a href="index.html" class="back-button">
                <i class="fas fa-arrow-left back-logo"></i> Back to Home
            </a>
        </div>
    </div>
    
</body>
</html>
