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

// Get id
$comment->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get comment
$comment->read_single();

if ($comment->id == null) {
  echo json_encode(array('Message' => 'No comment with this ID!'));
} else {

  // Create array
  $comment_arr = array(
    'id' => $comment->id,
    'contributor_name' => $comment->contributor_name,
    'email' => $comment->email,
    'date_of_publication' => $comment->date_of_publication,
    'text' => $comment->text,
    'article_title' => $comment->article_title
  );

  // Make JSON
  print_r(json_encode($comment_arr));
}
