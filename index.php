<?php

// Start the session.
session_start();
$valid = FALSE;
// Check session id is valid or not.
if ($_SESSION['id']) {
  $valid = TRUE;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <style>
    <?php include 'styles.css' ?>
  </style>
</head>
<body>
<?php if ($valid) :?>
  <?php include('./assignment6/html/index.php')?>
<form method="post" action="logout.php">
  <input type="submit" value="Logout">
</form>
<?php else : ?>
<div class="container">
<div class="card">
<h1>Home</h1>
<p><a href='login.php'>Login</a> Or <a href='register.php'> Sign up</p>
</div>
<?php endif; ?>
</div>
</body>
</html>
