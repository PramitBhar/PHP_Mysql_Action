<?php
/**
 * This class is used for Validate user given email username and password.
 *
 */
Class BackendValidation {
  /**
   * This function is used to check email address pattern is matched or not.
   *
   * @param string $email
   * This variable contains user given email address.
   *
   * @return bool
   */
  public function isEmailValid(string $email):bool {
    $pattern = "/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/";

    if (preg_match($pattern, $email)) {
      return TRUE;
    }
    return FALSE;
  }
  /**
   * This function is used to check user given password pattern is valid or not.
   *
   * @param string $password
   *This variable contain user given password.
   *
   * @return bool
   */
  public function isPasswordValid(string $password) :bool {
    $pattern = "/^[A-Za-z0-9-\#\$\.\%\&\*\@]+$/";
    if ($password!='' && preg_match($pattern, $password) && strlen($password)<=10) {
      return TRUE;
    }
    return FALSE;
  }
  /**
   * This function is used to validate user name.
   *
   * @param string $username
   * This variable contain user given username.
   *
   * @return bool
   */
  public function isValidUserName(string $username) :bool {
    $pattern = "/^[A-Za-z0-9]/";

    if ($username != NULL && preg_match($pattern, $username)) {
      return TRUE;
    }
    return FALSE;
  }
}
