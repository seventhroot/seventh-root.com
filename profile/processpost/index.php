<?php
include_once '../../includes/user.php';
include_once '../../includes/profile_post.php';
include_once '../../includes/parsedown.php';
include_once '../../includes/htmlpurifier/HTMLPurifier.auto.php';
session_start();
if (isset($_SESSION['user'])) {
  if (isset($_POST['post'])) {
    if (isset($_GET['id'])) {
      $parsedown = new Parsedown();
      $htmlpurifierconfig = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($htmlpurifierconfig);
      if (isset($_POST['reply_to'])) {
        $post = get_profile_post_by_id(create_profile_post(get_user_by_id($_GET['id']), $_SESSION['user'], $purifier->purify($parsedown->text($_POST['post'])), get_profile_post_by_id($_POST['reply_to'])));
      } else {
        $post = get_profile_post_by_id(create_profile_post(get_user_by_id($_GET['id']), $_SESSION['user'], $purifier->purify($parsedown->text($_POST['post']))));
      }
      header("HTTP/1.1 303 See Other");
      header("Location: /profile/?id=" . $_GET['id']);
    } else {
      header("HTTP/1.1 400 Bad Request");
    }
  } else {
    header("HTTP/1.1 400 Bad Request");
  }
} else {
  header("HTTP/1.1 400 Bad Request");
}
?>
