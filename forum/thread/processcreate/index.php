<?php
include_once '../../../includes/user.php';
include_once '../../../includes/topic.php';
include_once '../../../includes/thread.php';
include_once '../../../includes/post.php';
include_once '../../../includes/parsedown.php';
include_once '../../../includes/htmlpurifier/HTMLPurifier.auto.php';
session_start();
if (isset($_SESSION['user'])) {
  if (isset($_POST['create-thread'])) {
    if (isset($_GET['id'])) {
      $thread = get_thread_by_id(create_thread($_POST['title'], get_topic_by_id($_GET['id'])));
      $parsedown = new Parsedown();
      $htmlpurifierconfig = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($htmlpurifierconfig);
      create_post($thread, $_SESSION['user'], $purifier->purify($parsedown->text($_POST['text'])));
      header("HTTP/1.1 303 See Other");
      header("Location: /forum/thread/?id=" . $thread->get_id());
    } else {
      $thread = get_thread_by_id(create_thread($_POST['title']));
      $htmlpurifierconfig = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($htmlpurifierconfig);
      create_post($thread, $_SESSION['user'], $purifier->purify($parsedown->text($_POST['text'])));
      header("HTTP/1.1 303 See Other");
      header("Location: /forum/thread/?id=" . $thread->get_id());
    }
  } else {
    header("HTTP/1.1 400 Bad Request");
  }
} else {
  header("HTTP/1.1 400 Bad Request");
}
?>
