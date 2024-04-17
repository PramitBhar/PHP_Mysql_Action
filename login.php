<?php
session_start();
//Include database using this file.
include 'DatabaseConnection.php';
//This variable is used to check user given username and password is correct or not.
$isUserValid = TRUE;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    //Created new object.
    $connectDb = new DatabaseConnection();
    //This variable store the user given username.
    $username = $_POST['username'];
    $connectDb->connection();
    $userDetails = $connectDb->fetchingData($username);
    if ($userDetails) {
      if (password_verify($_POST['password'], $userDetails[0]['hash_password'])) {
        session_start();
        session_regenerate_id();
        $_SESSION['id'] = $userDetails[0]['id'];
        header('Location:index.php');
        exit;
      }
    }
    $isUserValid = FALSE;
  } catch (PDOException $e) {
    echo "There is some problem.".$e->getMessage();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
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
    <!-- Login Header -->
    <h1>Login</h1>
    <!-- Warning message -->
    <p class="warning_message">
    <!-- Warning message will be shown if user is give wrong username or passsword. -->
      <?php
      if (!$isUserValid) {
        echo "*Username or Password is not valid";
      }
      ?>
    </p>
    <!-- Input form -->
    <form method="post" action='<?php echo
        htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
      <div class="input-group mb-3">
        <span class="input-group-text">Username</span>
        <input type="text" name="username" class="form-control" maxlength="25" pattern="^[A-Za-z0-9]+$" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text">Password</span>
        <input type="password" name="password" class="form-control"
         maxlength="10" pattern="^[A-Za-z0-9-\#\$\.\%\&\*\@]+$" required>
      </div>
      <input type="submit" value="Login" class="btn btn-success">
    </form>
    <!-- Forgot password link. -->
    <a href="./forget_pass.php" class="card-link">Forgot Password?</a>
    <!-- Register user link. -->
    <a href="./register.php">Create your account</a>
  </div>
</div>
</body>
</html>
