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

// Get id
$article->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get article
$article->read_single();

if ($article->id == null) {
  echo json_encode(array('Message' => 'No article with this ID!'));
} else {

  // Create array
  $article_arr = array(
    'id' => $article->id,
    'text' => $article->text,
    'title' => $article->title,
    'date_of_publication' => $article->date_of_publication,
    'contributor_name' => $article->contributor_name,
  );

  // Make JSON
  print_r(json_encode($article_arr));
}
