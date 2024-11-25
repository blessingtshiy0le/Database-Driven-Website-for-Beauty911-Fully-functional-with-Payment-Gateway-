<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Product Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="style2.css" />
  <style>
    /* Center the form */
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .card {
      width: 80%;
      max-width: 600px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h4>Admin Product Management</h4>
      </div>
      <div class="card-body">
        <!-- Product management form -->
        <form action="add_product.php" method="post">
          <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" id="image" name="image" class="form-control">
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label for="page">Page</label>
            <select id="page" name="page" class="form-control">
              <option value="home">Home</option>
              <option value="services">Services</option>
              <option value="about">About</option>
              <!-- Add more options as needed -->
            </select>
          </div>
          <!-- Optionally, add dropdown for database table selection -->
          <!-- <div class="form-group">
            <label for="table">Database Table</label>
            <select id="table" name="table" class="form-control">
              <option value="table1">Table 1</option>
              <option value="table2">Table 2</option>
              <option value="table3">Table 3</option>
            </select>
          </div> -->
          <button type="submit" class="btn btn-primary btn-block">Add Product</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
