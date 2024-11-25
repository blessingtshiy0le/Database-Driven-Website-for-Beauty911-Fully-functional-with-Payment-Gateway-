<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];
    $productPrice = $_POST['product_price'];
    $servicePage = $_POST['service_page'];
    $productImage = $_FILES['product_image']['name'];
    
    // Upload image
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($productImage);

    // Create the uploads directory if it doesn't exist
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
        // Insert product into the database
        $sql = "INSERT INTO products (name, description, price, image, service_page) VALUES ('$productName', '$productDescription', '$productPrice', '$targetFile', '$servicePage')";
        
        if (mysqli_query($conn, $sql)) {
            echo "New product added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    
    mysqli_close($conn);
}
?>
