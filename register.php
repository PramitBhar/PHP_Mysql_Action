<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'DatabaseConnection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $first_name = $_POST['fname'];
  $last_name = $_POST['lname'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $id = uniqid();
  try {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user_details(first_name,last_name,id,email,username,hash_password)
    VALUES('$first_name','$last_name','$id','$email','$username','$hashed_password');";
    echo $sql;
    $connectDb = new DatabaseConnection();
    $connectDb->connection();
    $connectDb->insertData($sql);
    // header('Location:login.php');
  } catch (PDOException $e) {
    echo "User registration is not successful". $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
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
    <div class = "card">
      <h1>Register Your Details</h1>
      <form method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
        <div class="input-group mb-3">
          <span class="input-group-text">First name</span>
          <input type="text" name="fname" class="form-control" maxlength="25" pattern="^[A-Za-z]+$" required>
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text">Last name</span>
          <input type="text" name="lname" class="form-control" maxlength="25" pattern="^[A-Za-z]+$" required>
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text">Email</span>
          <input type="email" name="email" class="form-control" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$" required>
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text">Username</span>
          <input type="text" name="username" class="form-control" maxlength="15" pattern="^[A-Za-z]+$" required>
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text">Password</span>
          <input type="password" name="password" class="form-control"
          maxlength="10" pattern="^[A-Za-z0-9-\#\$\.\%\&\*\@]+$" required>
        </div>
        <input type="submit" value="Register" class="btn btn-success">
      </form>
    </div>
  </div>
</body>
</html>
