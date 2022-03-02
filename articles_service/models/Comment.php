<?php
class Comment
{
  // Database
  private $conn;
  private $table = 'comment';

  // Properties
  public $id;
  public $contributor_name;
  public $email;
  public $text;
  public $date_of_publication;
  public $article_id;
  public $article_title;

  // Constructor
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Get comments
  public function read()
  {
    // Query
    $query = 'SELECT a.title as article_title, c.id, c.article_id, c.contributor_name,c.text, c.email, c.date_of_publication
    FROM ' . $this->table . ' c LEFT JOIN article a ON c.article_id = a.id ORDER BY c.date_of_publication DESC';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }
}