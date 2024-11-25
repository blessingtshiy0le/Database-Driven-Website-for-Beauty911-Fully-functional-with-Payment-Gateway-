<?php
include 'db_connection.php';

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<div class='product'>";
        echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<p>$" . htmlspecialchars($row['price']) . "</p>";
        echo "<img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
        // Add the form to add the product to the cart
        echo "<form method='post'>";
        echo "<input type='hidden' name='product_id' value='" . $row["ID"] . "'>";
        echo "<button type='submit'>Add to Cart</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "No products found";
}

mysqli_close($conn);
?>
