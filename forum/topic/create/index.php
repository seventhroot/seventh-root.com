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
        echo '<form action="/forum/topic/processcreate/?id=' . $_GET['id'] . '" method=POST>';
      } else {
        echo '<form action="/forum/topic/processcreate/" method=POST>';
      }
      ?>
        Title: <input name="title" type="text" required><br />
        <input name="create-topic" value="1" type="hidden">
        <input value="Create topic" type="submit">
      </form>
    </div>
  </body>
</html>
