<?php
include 'db_connection.php'; // Ensure this file contains your database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL query
    $sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);

    try {
        if ($stmt->execute()) {
            // Redirect to admin panel
            header("Location: admin.html");
            exit(); // Make sure to exit after redirection
        } else {
            echo "Error: Admin already registered.";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: Admin already registered.";
    }

    $stmt->close();
    $conn->close();
}
?>
