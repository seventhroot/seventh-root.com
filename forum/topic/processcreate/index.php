<?php
include_once '../../../includes/user.php';
include_once '../../../includes/topic.php';
include_once '../../../includes/thread.php';
include_once '../../../includes/post.php';
include_once '../../../includes/parsedown.php';
include_once '../../../includes/permissions.php';
session_start();
if (isset($_SESSION['user'])) {
  if (has_permission($_SESSION['user'], 'CREATE_TOPIC')) {
    if (isset($_POST['create-topic'])) {
      if (isset($_GET['id'])) {
        $topic_id = create_topic($_POST['title'], get_topic_by_id($_GET['id']));
        header("HTTP/1.1 303 See Other");
        header("Location: /forum/topic/?id=" . $topic_id);
      } else {
        $topic_id = create_topic($_POST['title']);
        header("HTTP/1.1 303 See Other");
        header("Location: /forum/topic/?id=" . $topic_id);
      }
    } else {
      header("HTTP/1.1 400 Bad Request");
    }
  } else {
    header("HTTP/1.1 403 Forbidden");
  }
} else {
  header("HTTP/1.1 403 Forbidden");
}
?>
