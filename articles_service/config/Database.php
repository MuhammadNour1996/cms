<?php
class Database
{
  // Database parameters
  private $host = 'localhost';
  private $database_name = 'pindatabase';
  private $user_name = 'root';
  private $password = '';
  private $conn;

  // Database connection
  public function connect()
  {
    $this->conn = null;
    try {
      $this->conn = new PDO('mysql:host =' . $this->host . ';dbname=' . $this->database_name, $this->user_name, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo 'Connection error' . $e->getMessage();
    }
    return $this->conn;
  }
}
