<?php
// Initialize variables
$product_id = $product_name = $product_description = $product_price = '';
$image_error = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];

    // Handle image upload if provided
    if (!empty($_FILES['product_image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $image_error = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["product_image"]["size"] > 25500000) {
            $image_error = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $image_error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // If everything is ok, try to upload file
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                // File uploaded successfully, update database with image path
                include 'db_connection.php'; // Include your database connection script

                // Update query with image path
                $sql = "UPDATE products SET 
                        name = '$product_name',
                        description = '$product_description',
                        price = '$product_price',
                        image = '$target_file'
                        WHERE id = $product_id";

                if ($conn->query($sql) === TRUE) {
                    echo '<p>Product updated successfully.</p>';
                } else {
                    echo '<p>Error updating product: ' . $conn->error . '</p>';
                }

                // Close database connection
                $conn->close();
            } else {
                $image_error = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // If no new image is provided, update only other fields
        include 'db_connection.php'; // Include your database connection script

        // Update query without image path
        $sql = "UPDATE products SET 
                name = '$product_name',
                description = '$product_description',
                price = '$product_price'
                WHERE id = $product_id";

        if ($conn->query($sql) === TRUE) {
            echo '<p>Product updated successfully.</p>';
        } else {
            echo '<p>Error updating product: ' . $conn->error . '</p>';
        }

        // Close database connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Include necessary CSS files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="style2.css" />
    <style>
        /* Additional styles specific to edit_service.php */
        /* You can add more specific styles here */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .admin-panel {
            text-align: center;
            padding: 20px;
            border: 1px solid #000;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
        }

        form {
            text-align: left;
            margin-bottom: 20px;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: calc(100% - 22px); /* Adjusting for padding */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #000;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        button {
            padding: 10px 20px;
            background-color: #fee3ec;
            color: #000;
            border: 1px solid #000;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
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

        .section-divider {
            margin: 40px 0;
            border-top: 1px solid #ccc;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="admin-panel">
            <h1>Edit Product</h1>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <label for="product_id">Product ID:</label>
                <input type="text" id="product_id" name="product_id" value="<?php echo $product_id; ?>" required><br>
                
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" value="<?php echo $product_name; ?>" required><br>
                
                <label for="product_description">Product Description:</label>
                <textarea id="product_description" name="product_description" required><?php echo $product_description; ?></textarea><br>
                
                <label for="product_price">Product Price:</label>
                <input type="text" id="product_price" name="product_price" value="<?php echo $product_price; ?>" required><br>
                
                <label for="product_image">Product Image:</label>
                <input type="file" id="product_image" name="product_image"><br>
                
                <?php if (!empty($image_error)) : ?>
                    <p class="error-message"><?php echo $image_error; ?></p>
                <?php endif; ?>
                
                <button type="submit">Update Product</button>
            </form>

            <div class="section-divider"></div>

            <!-- Link back to product_list.php or other relevant pages -->
            <a href="product_list.php" class="link-button">View Products</a>
            <a href="admin_orders.php" class="link-button">View Orders</a>
            <a href="edit_product.php" class="link-button">Edit A Product</a>
        </div>
    </div>
</body>
</html>
