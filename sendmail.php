<?php

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$email = strtolower($email);
$mail = new PHPMailer(true);
try {
  $mail->isSMTP();
  $mail->Host       = 'smtp.gmail.com;';
  $mail->SMTPAuth   = true;
  $mail->Username   = 'rimobhar0426@gmail.com';
  $mail->Password   = 'rpelcfhpvhujticz';
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->Port       = 465;
  $mail->setFrom('rimobhar0426@gmail.com');
  $mail->addAddress($email);
  $mail->isHTML(true);
  $mail->Subject = 'Reset Password';
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
