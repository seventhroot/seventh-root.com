<?php
include_once '../../../includes/user.php';
include_once '../../../includes/topic.php';
include_once '../../../includes/thread.php';
include_once '../../../includes/post.php';
include_once '../../../includes/parsedown.php';
include_once '../../../includes/htmlpurifier/HTMLPurifier.auto.php';
session_start();
if (isset($_GET['id']) && isset($_POST['post_id']) && isset($_SESSION['user']) && isset($_POST['reply'])) {
  $thread_id = $_GET['id'];
  $post_id = $_POST['post_id'];
  $user = $_SESSION['user'];
  $parsedown = new Parsedown();
  $reply = $parsedown->text($_POST['reply']);
  $htmlpurifierconfig = HTMLPurifier_Config::createDefault();
  $purifier = new HTMLPurifier($htmlpurifierconfig);
  $reply = $purifier->purify($reply);
  create_post(get_thread_by_id($thread_id), $user, $reply, get_post_by_id($post_id));
  header("HTTP/1.1 303 See Other");
  header("Location: /forum/thread/?id=" . $thread_id);
} else {
  header("HTTP/1.1 400 Bad Request");
}
?>
