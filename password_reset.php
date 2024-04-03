<?php
//Inclde database using this file.
include 'DatabaseConnection.php';
// Create new object.
$connectDB = new DatabaseConnection();
// Connect Database.
$connectDB->connection();

if ($_SERVER["REQUEST_METHOD"]=="POST") {
  $token = $_POST["token"];
  $newPassword = $_POST["password"];
  $passwordConfirmation = $_POST["passwordConfirmation"];

  if ($newPassword !== $passwordConfirmation) {
    $isValid = TRUE;
    $message = "Passwords not matched.";
  }
  else if (!$isValid) {
    $user = $connectDB->validTokenOrNot($token);
    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $userId = $user[0]["id"];
    $upadtdingPassword = $connectDB->updatePassword($passwordHash, $userId);
    if ($upadtdingPassword) {
      header("Location:login.php");
    }
    else {
      $isValid = TRUE;
      $message = "Password reset is unsuccessful.";
    }
  }
}
else {
  $queryToken = $_GET["token"];
  $hashQueryToken = hash("sha256", $queryToken);
  $user = $connectDB->validTokenOrNot($hashQueryToken);
  $isValid = FALSE;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
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
      <h1>Reset Your Password</h1>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="token" value="<?= htmlspecialchars($hashQueryToken)?>">
        <div class="input-group mb-3">
          <span class="input-group-text">New Password</span>
          <input type="password" name="password" placeholder="enter your new password" class="form-control">
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text">Confirm Password</span>
          <input type="password" name="passwordConfirmation" placeholder="confirm your password" class="form-control">
        </div>
        <input type="submit" value="submit" name="submit" class="btn btn-success">
      </form>
    </div>
  </div>
</body>
</html>
