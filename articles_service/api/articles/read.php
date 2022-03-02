<?php
// Headers
header('Access-Contrlo-Allow-Origin: *');
header('Content-Type: application/json');

include_once '..//..//config/Database.php';
include_once '..//..//models/Article.php';

// Instantaite database & connect
$database = new Database();
$db = $database->connect();

// Instantaite article object
$article = new Article($db);

// Query
$result = $article->read();

// Get row count
$num = $result->rowCount();

// Check if there any article
if ($num > 0) {
  // Articles array
  $articles_arr = array();
  $articles_arr['data'] = array();
  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $article_item = array(
      'id' => $id,
      'contributor_name' => $contributor_name,
      'title' => $title,
      'text' => htmlentities($text),
      'date_of_publication' => $date_of_publication,
      );
      array_push($articles_arr['data'], $article_item);
  }
  // Convert to JSON
  echo json_encode($articles_arr);
} else {
  echo json_encode(array('message' => 'No articles'));
  
}
