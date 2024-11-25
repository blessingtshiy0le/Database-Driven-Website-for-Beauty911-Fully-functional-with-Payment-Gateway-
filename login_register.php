<?php
session_start();
include 'db_connection.php'; // Adjust path as necessary

// Initialize login attempt counter in session if not already set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // Sanitize inputs
        $username = trim($_POST['username']);
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email format.";
        } else {
            // Check if user already exists
            $check_user_stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
            $check_user_stmt->bind_param("s", $email);
            $check_user_stmt->execute();
            $result = $check_user_stmt->get_result();

            if ($result->num_rows > 0) {
                $message = "User already registered.";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user into the database
                $insert_user_stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $insert_user_stmt->bind_param("sss", $username, $email, $hashed_password);

                if ($insert_user_stmt->execute()) {
                    $message = "User successfully registered.";
                } else {
                    $message = "Error: Could not register user.";
                }
            }
        }
    } elseif (isset($_POST['login'])) {
        // Increment login attempt counter
        $_SESSION['login_attempts']++;

        // Check if login attempts exceed 3
        if ($_SESSION['login_attempts'] >= 3) {
            // Reset login attempts
            $_SESSION['login_attempts'] = 0;
            $message = "Incorrect password entered too many times, create a new account.";
        } else {
            // Sanitize inputs
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password']);
        
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = "Invalid email format.";
            } else {
                // Check if user exists
                $check_user_stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
                $check_user_stmt->bind_param("s", $email);
                $check_user_stmt->execute();
                $result = $check_user_stmt->get_result();
        
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        // Reset login attempt counter on successful login
                        $_SESSION['login_attempts'] = 0;
        
                        // Prevent session fixation
                        session_regenerate_id(true);
                        $_SESSION['user'] = $user;
                        header("Location: index.html"); // Redirect to index.php on successful login
                        exit();
                    } else {
                        $message = "Invalid password.";
                    }
                } else {
                    $message = "User not registered.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login/Register</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="style2.css">
<style>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.frame {
  background-color: #f9f9f9;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  max-width: 500px;
  width: 100%;
  border: 3px solid #000;
}

.form-heading {
  text-align: center;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
}

.form-group input {
  width: calc(100% - 20px); /* Adjust width to accommodate padding */
  padding: 10px; /* Keep consistent padding */
  border: 2px solid #000;
  border-radius: 5px;
  box-sizing: border-box;
}

.form-group input[type="email"] { 
  margin-left: 30px; /* Add left margin for email input */
}

.form-group .email-input {
  width: calc(100% - 20px); /* Adjust width to accommodate padding */
  padding: 10px; /* Keep consistent padding */
  border: 2px solid #000;
  border-radius: 5px;
  box-sizing: border-box;
  margin-left: 50px; /* Add left margin */
}

.form-group button {
  width: 100%;
  padding: 10px 0;
  background-color: #fee3ec;
  color: #000;
  border: 1px solid #000;
  border-radius: 5px;
  cursor: pointer;
}

.form-group button:hover {
  background-color: #fff;
}

.toggle-button {
  text-align: center;
  cursor: pointer;
  color: #007bff;
}

.toggle-button:hover {
  text-decoration: underline;
}

.back-button {
  width: 100%;
  padding: 10px 0;
  background-color: #fee3ec;
  color: #000;
  border: 1px solid #000;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 10px;
}

.back-button:hover {
  background-color: #ccc;
}
</style>
<script>
function toggleForm() {
    var registerForm = document.getElementById("register-form");
    var loginForm = document.getElementById("login-form");
    var toggleButton = document.getElementById("toggle-button");

    if (registerForm.style.display === "none") {
        registerForm.style.display = "block";
        loginForm.style.display = "none";
        toggleButton.innerHTML = "Already have an account? Login";
    } else {
        registerForm.style.display = "none";
        loginForm.style.display = "block";
        toggleButton.innerHTML = "Don't have an account? Register";
    }
}
</script>
</head>
<body>

<div class="container">
  <div class="frame">
    <h2 class="form-heading">Account Center</h2>

    <?php if (isset($message)) { echo "<p style='color:red;'>$message</p>"; } ?>

    <div id="register-form">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
          <button type="submit" name="register">Register</button>
        </div>
      </form>
      <button class="back-button" onclick="window.location.href='index.html'">Back</button>
    </div>

    <div id="login-form" style="display:none;">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
          <label for="email-login">Email:</label>
          <input type="email" id="email-login" name="email" required>
        </div>
        <div class="form-group">
          <label for="password-login">Password:</label>
          <input type="password" id="password-login" name="password" required>
        </div>
        <div class="form-group">
          <button type="submit" name="login">Login</button>
        </div>
      </form>
      <button class="back-button" onclick="window.location.href='index.html'">Back</button>
    </div>

    <div class="toggle-button" id="toggle-button" onclick="toggleForm()">
      Already have an account? Login
    </div>
  </div>
</div>

</body>
</html>
