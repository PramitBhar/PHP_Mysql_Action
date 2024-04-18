<?php

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
// Convert the email to lowercase.
$email = strtolower($email);
$mail = new PHPMailer(true);
try {
  // Server settings.
  $mail->isSMTP();
// Set the host of the SMPT server
  $mail->Host       = 'smtp.gmail.com;';
  $mail->SMTPAuth   = true;
  // Set the username of the SMPT server.
  $mail->Username   = 'rimobhar0426@gmail.com';
  // Set the password of the SMPT server.
  $mail->Password   = 'rpelcfhpvhujticz';
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  // Set the port of the SMPT.
  $mail->Port       = 465;
  // Set the mail address from where mail will be sent.
  $mail->setFrom('rimobhar0426@gmail.com');
  $mail->addAddress($email);
  $mail->isHTML(true);
  // Set the email subject.
  $mail->Subject = 'Reset Password';
  // Set the mail body.
  $mail->Body    = <<<END
  <b>Click <a href="http://sqlasg3.com/password_reset.php?token=$token">here</b> to change your password.
  Link will be expired after 5 minutes.
  END;
  $mail->AltBody = 'Body in plain text for non-HTML mail clients';
  $mail->send();
  echo "Mail has been sent successfully!";
}
catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
