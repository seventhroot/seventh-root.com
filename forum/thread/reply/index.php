<?php
include_once '../../../includes/user.php';
include_once '../../../includes/topic.php';
include_once '../../../includes/thread.php';
include '../../../includes/post_reply_form.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Reply</title>
    <?php include '../../../includes/stylesheets.php'; ?>
  </head>
  <body>
    <div id="main">
      <?php
      include '../../../includes/logo.php';
      if (isset($_SESSION['user'])) {
        include '../../../includes/navigation.php';
        $post_id = NULL;
        if (isset($_GET['post_id'])) {
          $post_id = $_GET['post_id'];
        }
        $thread_id = NULL;
        if (isset($_GET['thread_id'])) {
          $thread_id = $_GET['thread_id'];
        }
        if ($post_id !== NULL && $thread_id !== NULL) {
          get_thread_by_id($thread_id)->print_path();
          print_reply_form($thread_id, $post_id);
        }
      } else {
        include '../../../includes/navigation_beforelogin.php';
        echo 'You may not reply to posts without logging in.';
      }
      ?>
    </div>
  </body>
</html>
