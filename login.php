<?php
session_start();
include 'db_connection.php'; // Ensure this file contains your database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input to prevent empty or invalid data
    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit();
    }

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log('mysqli prepare() failed: ' . htmlspecialchars($conn->error));
        exit('Database error');
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the user exists and verify the password
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            $_SESSION['admin'] = $username;
            // Redirect to admin panel
            header("Location: admin.html");
            exit(); // Make sure to exit after redirection
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
