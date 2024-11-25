<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #000;
        }
        th {
            background-color: #fee3ec;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        .container {
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .back-button {
            width: 20%;
            padding: 10px;
            border: 1px solid #000;
            border-radius: 5px;
            background-color: #fee3ec;
            color: #000;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #fff;
        }
        .link-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #fee3ec;
            color: #000;
            border: 1px solid #000;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            margin-top: 10px;
        }
        .link-button:hover {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Orders</h1>
        <?php
        include 'db_connection.php'; 

        // Fetch orders from the database
        $sql = "SELECT id, name, email, booking_datetime, total_amount, payment_status FROM payments";
        $result = $conn->query($sql);

        if ($result === false) {
            echo "<p>Error: " . $conn->error . "</p>";
        } elseif ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Booking Date & Time</th><th>Total Amount</th><th>Payment Status</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["booking_datetime"]) . "</td>";
                echo "<td>R " . number_format($row["total_amount"], 2) . "</td>";
                echo "<td>" . htmlspecialchars($row["payment_status"]) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No orders found.</p>";
        }

        $conn->close();
        ?>
        <a href="admin.html" class="link-button">Back To Admin</a>
    </div>
</body>
</html>
