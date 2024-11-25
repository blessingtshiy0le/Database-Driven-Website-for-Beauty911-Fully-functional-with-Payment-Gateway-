<?php
// Include database connection file
include_once 'db_connection.php';

if(isset($_POST['id']) && isset($_POST['status'])) {
    // Sanitize input data
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update status in the database
    $sql = "UPDATE payments SET payment_status = '$status' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        // Status updated successfully
        echo "Status updated successfully";
    } else {
        // Error updating status
        echo "Error updating status: " . $conn->error;
    }
}

$conn->close();
?>
