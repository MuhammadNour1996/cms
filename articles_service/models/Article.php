<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/articles_service/Interfaces/ArticleInterface.php";
require $path;
class Article implements ArticleInterface
{
  // Database
  private $conn;
  private $table = 'article';

  // Properties
  public $id;
  public $title;
  public $text;
  public $date_of_publication;
  public $contributor_name;

  // Constructor
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Get articles
  public function read()
  {
    // Query
    $query = 'SELECT a.id, a.title, a.contributor_name, a.text, a.date_of_publication
    FROM ' . $this->table . ' as a ORDER BY a.date_of_publication DESC';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get single article
  public function read_single()
  {
    // Query
    $query = 'SELECT a.id, a.title, a.contributor_name, a.text, a.date_of_publication
    FROM ' . $this->table . ' as a WHERE a.id = ? LIMIT 0,1';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set properties
    $this->id = $row['id'];
    $this->text = $row['text'];
    $this->date_of_publication = $row['date_of_publication'];
    $this->title = $row['title'];
    $this->contributor_name = $row['contributor_name'];
  }

  // Create article
  public function create()
  {
    // Query
    $query = "INSERT INTO " . $this->table . " (title, contributor_name, text) VALUES (:title, :contributor_name, :text)";

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->contributor_name = htmlspecialchars(strip_tags($this->contributor_name));
    $this->text = htmlspecialchars(strip_tags($this->text));

    // Bind data
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':contributor_name', $this->contributor_name);
    $stmt->bindParam(':text', $this->text);

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
