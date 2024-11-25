<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotions</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-YQQUDZpPmG/Jzwyf+qaex8V6RbcJyO83lIMFZJ7v3Nz/JB3A4xHmwe9cH4ws4Azr" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fee3ec;
        }
        .blog-post {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 200px auto; /* Center horizontally with 200px top and bottom margin */
            max-width: 900px;
            padding: 50px; /* Added padding */
            width: 100%;
}


        .blog-post img {
            border-radius: 5px;
            max-width: 100%;
            height: 100%;
        }

        .blog-post h2 {
            color: #f98cac;
            margin-top: 0.5em;
        }

        .blog-post p {
            color: #000;
            line-height: 1.6;
        }

        /* Additional styles for layout */
        main {
            padding: 20px;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <!-- Your header content -->
        
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
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="contact-main">
                            <a href="login_register.php">Login/Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-nav">
            <div class="container">
                <nav>
                    <div>
                        <a href="index.html" class="active"></i>HOME</a>
                    </div>
                    <div>
                        <a href="haircare.php"></i>Hair Care</a>
                    </div>
                    <div>
                        <a href="facials.php"></i>Facial Treatments (Teens Only)</a>
                    </div>
                    <div>
                        <a href="nails.php"></i>Nails</a>
                    </div>
                    <div>
                        <a href="ivdrips.php"></i>IV Therapy</a>
                    </div>
                    <div>
                        <a href="hair_removal.php"></i>Makeup</a>
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

    <main>
        <!-- Blog posts loop -->
        <?php
        // Include your PHP logic for displaying blog posts here
        // Example:
        $posts = json_decode(file_get_contents('posts.json'), true);
        foreach ($posts as $post) {
            echo '<section class="blog-post">';
            echo '<img src="' . $post['image'] . '" alt="' . $post['title'] . '">';
            echo '<h2>' . $post['title'] . '</h2>';
            echo '<p>' . nl2br($post['content']) . '</p>'; // Preserve line breaks
            echo '</section>';
        }
        ?>
    </main>

    <footer class="main-footer">
        <!-- Your footer content -->
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
