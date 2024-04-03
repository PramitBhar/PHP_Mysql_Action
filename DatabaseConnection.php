<?php

// namespace MyDatabase;

error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'loadenv.php';
/**
 * Class databaseConnection is used for connect database.
 */
class DatabaseConnection {
  /**
   * @var string $serverName
   * servername store the database host name.
   */
  private $serverName;
  /**
   * @var string $dbName
   * database name is stored inside dbName.
   */
  private $dbName;
  /**
   * @var string $userName
   * It is used to store username.
   */
  private $userName;
  /**
   * @var string $password
   * It is used to store password.
   */
  private $password;
  /**
   * @var string $conn.
   * It stores connection.
   */
  public $conn;

  /**
   * This constructor is used to set hostname ,username, password and database name.
   */
  public function __construct() {
    $this->serverName = $_ENV['My_db_host'];
    $this->userName = $_ENV['username'];
    $this->password = $_ENV['password'];
    $this->dbName = $_ENV['My_dbName'];
  }
  /**
   * This is function is used for connecting database.
   * @return string
   */
  public function connection() {
    try {
      $this->conn = new PDO("mysql:host=$this->serverName;dbname=$this->dbName", $this->userName, $this->password);
      // set the PDO error mode to exception
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    }
    catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  public function insertData(string $sql) {
    try {
      $statement = $this->conn->prepare($sql);
      $statement->execute();
    }
    catch (PDOException $e) {
      echo "Data insertion failed " . $e->getMessage();
    }
  }
  /**
   * This function is used to fetch all data of a table.
   *
   * @param string $user
   * Contain the tablename whose data to be fetched.
   *
   * @return string $results
   * Contain all the rows and column of a table.
   */
  public function fetchingData(string $user) {
    $query1 = "SELECT * FROM user_details where username='$user'";
    // $query1 = "$query" . "$tableName";
    $stmt = $this->conn->prepare($query1);
    $stmt->execute();
    $results = $stmt->fetchAll();
    return $results;
  }
  /**
   * Gerates Token to verify e-mail.
   *
   * This function is used to generate tokens every time when user hit forget
   * password submit form.After that one token will be genrated and token will
   * be valid only for 5 minutes after generating.Store this genrated tokens and
   * expirey time in the user database.Basically this function verify user e-mail
   * is present in the database and send e-mail to the verified user.
   */
  public function generateToken($email) {
    //this variable contain unique id using php in-built function.
    $token = bin2hex(uniqid());
    //this variable contains the hash value of the unique token.
    $hash_token = hash("sha256", $token);
    //this variable contain the time stamp as a string until token is valid.
    $token_expire_at = date("Y-m-d H:i:s", time()+(60*5));
    //this variable contains sql query which help us to update user_details info.
    $query = "UPDATE user_details SET reset_token= ?, reset_token_expires= ? where email= ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(1, $hash_token);
    $stmt->bindValue(2, $token_expire_at);
    $stmt->bindValue(3, $email);
    $stmt->execute();
    // this if case checked sql query value affected any row,column or not.
    if ($stmt->rowCount() > 0) {
      //this php file contains the smtp server.
      include 'sendmail.php';
    }
    //Otherwise user given e-mail is not registered.
    else {
      echo "Entered mail is not registered";
    }
  }
  /**
   * This function is used to token is validate or not
   *
   * @param string $token
   */
  public function validTokenOrNot(string $token) {
    $sqlQuery = "SELECT * from user_details where reset_token='$token'";
    $stmt = $this->conn->prepare($sqlQuery);
    // $stmt->bindValue(1, $token);
    $stmt->execute();
    // $result = $stmt->bind_result();
    $user = $stmt->fetchAll();
    print_r($user);
    if ($user === NULL) {
      die("Token not found");
    }
    print_r($user[0]['reset_token_expires']);
    if (strtotime($user[0]['reset_token_expires']) <= time()) {
      die("Token has been expired");
    }
    return $user;
  }
  /**
   * This function is used to update password of a user.
   *
   * @param string $newPassword
   * it contains the user given new hashed password.
   *
   * @param string $userId
   * it contains the unique user id of a user.
   *
   * @return bool
   * if password updated successfully then it return true otherwise false.
   */
  public function updatePassword(string $newPassword, string $userId):bool {
    try {
      $query = "UPDATE user_details SET hash_password=?,
      reset_token=NULL,reset_token_expires=NULL where id=?";
      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(1, $newPassword);
      $stmt->bindValue(2, $userId);
      $stmt->execute();
      return TRUE;
    } catch (PDOException $e) {
      return FALSE;
    }
  }
}
