<?php
include_once '../../../includes/user.php';
include_once '../../../includes/topic.php';
include_once '../../../includes/thread.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Create Thread</title>
    <?php include '../../../includes/stylesheets.php'; ?>
  </head>
  <body>
    <div id="main">
      <?php
      include '../../../includes/logo.php';
      if (isset($_SESSION['user'])) {
        include '../../../includes/navigation.php';
      } else {
        include '../../../includes/navigation_beforelogin.php';
      }
      if (isset($_GET['id'])) {
        echo '<form action="/forum/thread/processcreate/?id=' . $_GET['id'] . '" method=POST>';
        echo 'Title: <input name="title" type="text" required><br />';
        echo '<textarea name="text"></textarea><br />';
        echo '<input name="create-thread", value="1" type="hidden">';
        echo '<input value="Create thread" type="submit">';
        echo '</form>';
      }
      ?>
    </div>
  </body>
</html>
