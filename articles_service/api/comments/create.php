<?php
// Headers
header('Access-Contrlo-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Contrlo-Allow-Methods: POST');
header('Access-Contrlo-Allow-Headers: Access-Contrlo-Allow-Headers,Content-Type,Access-Contrlo-Allow-Methods,Authorization,X-Requested-With');

include_once '..//..//config/Database.php';
include_once '..//..//models/Comment.php';

// Instantaite database & connect
$database = new Database();
$db = $database->connect();

// Instantaite comment object
$comment = new Comment($db);

// Get posted data row
$data = json_decode(file_get_contents("php://input"));

$comment->text = $data->text;
$comment->email = $data->email;
$comment->article_id = $data->article_id;
$comment->contributor_name = $data->contributor_name;

// Create article
if ($comment->create()) {
  echo json_encode(array('Message' => 'Comment created!'));
} else {
  echo json_encode(array('Message' => 'Comment not created!'));
}
