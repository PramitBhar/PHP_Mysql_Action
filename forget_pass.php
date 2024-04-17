<?php

include 'DatabaseConnection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $connectDb = new DatabaseConnection();
  $connectDb->connection();
  $connectDb->generateToken($_POST['email']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forget Password Page</title>
  <link rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
  integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
  crossorigin="anonymous">
  <style>
    <?php include 'styles.css'?>
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h1>Forget Password</h1>
      <form method="post" action="">
        <div class="input-group mb-3">
          <span class="input-group-text">Enter your registered email address:</span>
          <input type="email" name="email" value="email" class="form-control"/>
        </div>
        <input type="submit" name="submit" value="submit" class="btn btn-success"/>
      </form>
      </div>
  </div>
</body>
</html>
