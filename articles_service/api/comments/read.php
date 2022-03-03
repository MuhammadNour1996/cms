<?php
// Headers
header('Access-Contrlo-Allow-Origin: *');
header('Content-Type: application/json');

include_once '..//..//config/Database.php';
include_once '..//..//models/Comment.php';

// Instantaite database & connect
$database = new Database();
$db = $database->connect();

// Instantaite comment object
$comment = new Comment($db);

// Query
$result = $comment->read();

// Get row count
$num = $result->rowCount();

// Check if there any comment
if ($num > 0) {
  // Comments array
  $comments_arr = array();
  $comments_arr['data'] = array();
  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $comment_item = array(
      'id' => $id,
      'contributor_name' => $contributor_name,
      'email' => $email,
      'text' => htmlentities($text),
      'date_of_publication' => $date_of_publication,
      'article_id' => $article_id,
      'article_title' => $article_title
      );
      array_push($comments_arr['data'], $comment_item);
  }
  // Convert to JSON
  echo json_encode($comments_arr);
} else {
  echo json_encode(array('message' => 'No comments'));
}
