<?php
include_once '../includes/user.php';
include_once '../includes/permissions.php';
include_once '../includes/database_settings.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Forum</title>
    <?php include '../includes/stylesheets.php'; ?>
  </head>
  <body>
    <div id="main">
      <?php
      include '../includes/logo.php';
      if (isset($_SESSION['user'])) {
        include '../includes/navigation.php';
      } else {
        include '../includes/navigation_beforelogin.php';
      }
      echo '<div class="path">' . "\n";
      echo ' &raquo; Forum' . "\n";
      echo '</div>' . "\n";
      $mysqli = new mysqli(get_db_host(), get_db_user(), get_db_password(), get_db_database());
      $stmt = $mysqli->prepare("SELECT id, title FROM topic WHERE parent IS NULL");
      $stmt->execute();
      $res = $stmt->get_result();
      echo '<h1>Topics</h1>';
      if (isset($_SESSION['user'])) {
        if (has_permission($_SESSION['user'], 'CREATE_TOPIC')) {
          echo '<h4><a href="/forum/topic/create">Create Topic</a></h4>';
        }
      }
      echo '<div id="topics">';
      while ($topic = $res->fetch_array(MYSQL_ASSOC)) {
        echo '<div class="topic"><a href="/forum/topic/?id=' . $topic['id'] . '"><h1>' . $topic['title'] . '</h1></a></div>';
      }
      echo '</div>';
      $stmt->close();
      ?>
    </div>
  </body>
</html>
