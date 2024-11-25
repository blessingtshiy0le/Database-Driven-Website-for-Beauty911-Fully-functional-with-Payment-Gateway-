<?php
include 'db_connection.php';

// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    // Retrieve product ID from the form data
    $product_id = $_POST["product_id"];

    // Retrieve product details from the database based on the product ID
    $sql = "SELECT * FROM products WHERE ID = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Add the product to the cart session
        $_SESSION['cart'][] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price']
        );

        // Redirect back to the same page after adding the product to the cart
        header("Location: haircare.php");
        exit();
    }
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=950, initial-scale=1, shrink-to-fit=no">
<title>Hair Care Products</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="style2.css">
<style>
.row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Add gap between columns */
  }
  .col-4 {
    width: calc(33.33% - 20px); /* 3 columns in a row with gap */
    padding: 10px;
  }
  .product-card {
    text-align: center;
    border: 3px solid #000; /* Add border */
    padding: 20px;
    border-radius: 5px; /* Add border-radius for rounded corners */
    height: 100%; /* Ensure consistent height */
  }
  .product-card img {
    width: 96%; /* Make images fill the width of the container */
    height: auto; /* Maintain aspect ratio */
    max-height: 250px; /* Limit maximum height */
    margin-bottom: 20px; /* Add space between image and content */
  }
  .product-card h3,
  .product-card p,
  .product-card .btn {
    margin-bottom: 10px; /* Add space between elements */
  }
  .product-card .btn {
    border: 1px solid #000;
    padding: 10px 20px; /* Add padding to button */
  }
  .main-header {
    position: relative;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 10;
  }
  .main-info {
    color: #000000;
    padding: 1.5em 1 1em;
    text-align: left;
    position: relative;
  }
  .main-nav {
    margin: auto;
  }

  .main-nav nav {
    margin-left: 15px;
    margin-right: 15px;
    background: rgba(243, 157, 182, 0.15);
    backdrop-filter: blur(4.6px);
    -webkit-backdrop-filter: blur(4.6px);
    display: flex;
    justify-content: space-between;
  }

  .main-nav nav a {
    display: block;
    padding: 1.5rem 1rem;
    color: #000000;
    font-size: 0.95rem;
    font-weight: 600;
    letter-spacing: 1px;
  }
  .main-nav nav a:hover,
  .main-nav nav a:focus,
  .main-nav nav a.active {
    background-color: #efa6baa6;
  }

  .main-footer {
    font-size: 0.9rem;
    line-height: 1.5;
    padding-top: 3em;
    padding-bottom: 2em; /* Set the original padding-bottom */
    color: #000000;
    background-color: #f98cac;
    position: relative;
    top: 50px; /* Adjust the top position to lower the footer */
  }
</style>
</head>
<body>

<header class="main-header">
  <div class="main-info">
    <div class="container">
      <div class="row">
        <h1 class="logo">
          <a href="#">
            <img src="images/logo.png" class="logo-light" />
          </a>
        </h1>
            <div class="contact">
              <div class="contact-icon">
                  <i class="fas fa-gift"></i> <!-- Use "fas" for Font Awesome Solid style -->
              </div>
              <div class="contact-main">
                  <a href="promotions.php">Promotions</a>
              </div>
        </div>
      </div>
    </div>
  </div>
  <div class="main-nav">
    <div class="container">
      <nav>
        <div>
          <a href="index.html" class="active"><i class="fa-solid fa-house"></i>HOME</a>
        </div>
        <div>
          <a href="haircare.php"></i> Hair Care</a>
        </div>
        <div>
          <a href="facials.php"></i>Facial Treatments (Teens Only)</a>
        </div>
        <div>
          <a href="nails.php"></i>Nails</a>
        </div>
        <div>
          <a href="ivdrip_consent.html"></i>IV Therapy</a>
        </div>
        <div>
          <a href="makeup.php"></i></i>Makeup</a>
        </div>
        <div>
          <a href="eyelashextension.php"></i>Eyelash Extensions</a>
        </div>
        <div class="search">
          <a href="cart.php" class="cart-button">
            <i class="fas fa-shopping-cart"></i>Cart
          </a>              
        </div>
      </nav>
    </div>
  </div>
</header> 

<div class="container">
  <div class="row">
  <?php
    // Fetch products from the database
    $sql = "SELECT * FROM products WHERE service_page = 'Hair Care'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Display product cards
            echo "<div class='col-4'>";
            echo "<div class='product-card'>";
            echo "<img src='" . htmlspecialchars($row["image"]) . "' alt='Product Image'>";
            echo "<h3>" . htmlspecialchars($row["name"]) . "</h3>";
            echo "<p>" . htmlspecialchars($row["description"]) . "</p>";
            echo "<p><strong>Price: R" . htmlspecialchars($row["price"]) . "</strong></p>";
            // Add form for submitting product ID
            echo "<form method='post'>";
            echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row["id"]) . "'>";
            echo "<button type='submit' class='btn'>Add to Cart</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
  </div>
</div>

<footer class="main-footer">
  <div class="container">
      <div class="row">
        <div class="col-4">
          <div class="footer-logo">
              <a href="#">
                  <img src="images/logo.png" class="logo-light" />
              </a>
          </div>
          <ul class="sns">
              <li class="icon-fb">
                  <a href="facebook.html"><i class="fab fa-facebook-f"></i></a>
              </li>
              <li class="icon-twitter">
                  <a href="twitter.html"><i class="fab fa-twitter"></i></a>
              </li>
              <li class="icon-instagram">
                  <a href="https://www.instagram.com/beauty911_mobilesalon/"><i class="fab fa-instagram"></i></a>
              </li>
              <li class="icon-pinterest">
                  <a href="https://wa.me/+27743574899"><i class="fab fa-whatsapp"></i></a>
              </li>
          </ul>
      </div>          
          <div class="col-4">
              <h3>CONTACT US</h3>
              <div class="contact">
                  <div class="contact-icon">
                      <i class="fas fa-phone-alt"></i>
                  </div>
                  <div class="contact-main">
                          <a href="tel:+27743574899">+27 74 357 4899</a>
                      </div>
              </div>
              <div class="contact">
                  <div class="contact-icon">
                      <i class="fas fa-map-marker-alt"></i>
                  </div>
                  <div class="contact-main">
                      <a href="https://maps.google.com/maps?q=425+Granite+Crescent,+Centurion">425 Granite Crescent, Centurion</a>
                  </div>
              </div>
              <div class="contact">
                  <div class="contact-icon">
                      <i class="fas fa-envelope"></i>
                  </div>
                  <div class="contact-main">
                      <a href="mailto:info@beauty911.co.za">Admin@beauty911.co.za</a>
                  </div>
              </div>
          </div>
          <div class="col-4">
            <h3>Stay In Touch</h3>
            <p>Enter your email address to receive up-to-date news on services & more.</p>
            <form action="subscribers.php" method="post">
                <div class="form-group">
                    <input class="form-control" type="text" name="email" placeholder="Your e-mail..." />
                    <button class="submit-btn" type="submit">Subscribe</button>
                </div>
            </form>
        </div>            
        <div class="row">
              <div class="copyright">© 2024 Built by <a href="https://www.linkedin.com/in/blessing-tshiyole-2a5195209">Blessing Tshiyole</a></div>
          </div> 
  </div>
</footer>  
<script src="script.js"></script> <!-- Include your script.js file -->
<div id=goTop class=goTop></div>
    <script src=jqury.min.js></script>
    <script>
      $(function() {
        $(window).scroll(function() {
          if ($(document).scrollTop() > 60) {
            $(".main-nav").addClass("sticky")
          } else {
            $(".main-nav").removeClass("sticky")
          }
        });
        $("#goTop").click(function() {
          $("html,body").animate({
            scrollTop: 0
          }, "slow");
          return false
        });
        $(window).scroll(function() {
          if ($(this).scrollTop() > 300) {
            $("#goTop").addClass("active")
          } else {
            $("#goTop").removeClass("active");
            return false
          }
        }).scroll()
      });
    </script>
</body>
</html>
