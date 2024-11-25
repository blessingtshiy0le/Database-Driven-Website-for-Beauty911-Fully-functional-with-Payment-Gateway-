<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin IV Therapy Consent Forms</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <style>
        /* Additional styles for admin orders page */
        /* Style for the table */
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
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #ddd;
        }
        
        /* Style for action links */
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
    </style>
</head>
<body>

<div class="container">
    <div class="admin-panel">
        <h2>IV Therapy Consent Forms</h2>

        <?php
        // PHP code for displaying IV therapy consent forms
        // Include database connection file
        include_once 'db_connection.php';

        // Attempt to query IV therapy consent forms
        $sql = "SELECT * FROM consent_forms";
        $result = $conn->query($sql); 

        if ($result) {
            if ($result->num_rows > 0) {
                // Output data of each row
                echo "<table>
                        <tr>
                            <th>Name</th>
                            <th>Underlying Health Conditions</th>
                            <th>Signature</th>
                        </tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["your_name"]."</td>";
                    // Display 'Yes' or 'No' for health conditions based on user input
                    echo "<td>".($row["health_conditions"] == 'yes' ? 'Yes' : 'No')."</td>";
                    // Display 'Yes' for signature assuming it's provided
                    echo "<td>Yes</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No IV therapy consent forms submitted.";
            }
        } else {
            echo "Error fetching IV therapy consent forms: " . $conn->error;
        }

        $conn->close();
        ?>
        
        <!-- Back button to navigate back to the admin page -->
        <a href="admin.html" class="back-button">Back to Admin Panel</a>

    </div>
</div>

</body>
</html>
