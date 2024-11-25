<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "beauty911";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Validate and sanitize input
   $yourName = isset($_POST['your_name']) ? $_POST['your_name'] : '';
   $signatureData = $_POST['signature'];
   $healthConditions = isset($_POST['underlying_conditions']) ? $_POST['underlying_conditions'] : 'no'; // default to 'no' if not set

   // Validate inputs (basic example, adjust as needed)
   if (empty($yourName) || empty($signatureData)) {
       die("Error: Name and Signature are required.");
   }

   // Sanitize data for SQL injection prevention (not strictly necessary for signatures but good practice)
   $yourName = filter_var($yourName, FILTER_SANITIZE_STRING);
   $signatureData = filter_var($signatureData, FILTER_SANITIZE_STRING);
   $healthConditions = filter_var($healthConditions, FILTER_SANITIZE_STRING);

   // Create connection
   $conn = new mysqli($servername, $username, $password, $database);

   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }

   // Prepare and bind SQL statement to insert data into database
   $stmt = $conn->prepare("INSERT INTO consent_forms (your_name, signature_data, health_conditions) VALUES (?, ?, ?)");
   $stmt->bind_param("sss", $yourName, $signatureData, $healthConditions);

   // Execute SQL statement
   if ($stmt->execute()) {
       // Redirect to success page or do something else on success
       header("Location: ivdrips.php");
       exit();
   } else {
       // Handle SQL error
       echo "Error: " . $stmt->error;
   }

   // Close statement and database connection
   $stmt->close();
   $conn->close();
}
?>
