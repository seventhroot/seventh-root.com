<?php
include_once '../../includes/user.php';
include_once '../../includes/topic.php';
include_once '../../includes/thread.php';
include_once '../../includes/post.php';
include_once '../../includes/parsedown.php';
include_once '../../includes/htmlpurifier/HTMLPurifier.auto.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Thread</title>
    <?php include '../../includes/stylesheets.php'; ?>
  </head>
  <body>
    <div id="main">
      <?php
      include '../../includes/logo.php';
      if (isset($_SESSION['user'])) {
        include '../../includes/navigation.php';
      } else {
        include '../../includes/navigation_beforelogin.php';
      }
      $id = NULL;
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
      }
      if ($id !== NULL) {
        echo '<div class="path">' . "\n";
        get_thread_by_id($id)->print_path();
        echo '</div>' . "\n";
        get_thread_by_id($id)->draw();
      }
      ?>
    </div>
  </body>
</html>
