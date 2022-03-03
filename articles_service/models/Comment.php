<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/articles_service/Interfaces/CommentInterface.php";
require $path;
class Comment implements CommentInterface
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

  // Get single comment
  public function read_single()
  {
    // Query
    $query = 'SELECT a.title as article_title, c.id, c.article_id, c.contributor_name,c.text, c.email, c.date_of_publication
    FROM ' . $this->table . ' c LEFT JOIN article a ON c.article_id = a.id WHERE a.id = ? LIMIT 0,1';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set properties
    $this->id = $row['id'];
    $this->email = $row['email'];
    $this->contributor_name = $row['contributor_name'];
    $this->date_of_publication = $row['date_of_publication'];
    $this->text = $row['text'];
    $this->article_title = $row['article_title'];
  }

  // Create comment
  public function create()
  {
    // Query
    $query = "INSERT INTO " . $this->table . " (text, contributor_name, email,article_id) VALUES (:text, :contributor_name, :email,:article_id)";

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->contributor_name = htmlspecialchars(strip_tags($this->contributor_name));
    $this->text = htmlspecialchars(strip_tags($this->text));
    $this->article_id = htmlspecialchars(strip_tags($this->article_id));

    // Bind data
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':contributor_name', $this->contributor_name);
    $stmt->bindParam(':text', $this->text);
    $stmt->bindParam(':article_id', $this->article_id);


    // Execute query
    if ($stmt->execute()) {
      return true;
    } else {
      // Error message
      printf("Error: %s. <br />" . $stmt->error);
      return false;
    }
  }
}
