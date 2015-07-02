<?php
include_once '../../includes/user.php';
include_once '../../includes/topic.php';
include_once '../../includes/thread.php';
include_once '../../includes/post.php';
include_once '../../includes/parsedown.php';
include_once '../../includes/permissions.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Topic</title>
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
      $mysqli = new mysqli("localhost", "seventhroot", "mN6?XdL)%jK", "seventhroot");
      $stmt = NULL;
      if (is_null($id)) {
        $stmt = $mysqli->prepare("SELECT id, title FROM topic WHERE parent IS NULL");
      } else {
        echo '<div class="path">' . "\n";
        get_topic_by_id($id)->print_path();
        echo '</div>';
        $stmt = $mysqli->prepare("SELECT id, title FROM topic WHERE parent = ?");
        $stmt->bind_param("i", $id);
      }
      $stmt->execute();
      $res = $stmt->get_result();
      echo '<h1>Topics</h1>';
      if (isset($_SESSION['user'])) {
        if (!is_null($id)) {
          if (has_permission($_SESSION['user'], 'CREATE_TOPIC')) {
            echo '<h4><a href="/forum/topic/create/?id=' . $id . '">Create Topic</a></h4>';
          }
        } else {
          if (has_permission($_SESSION['user'], 'CREATE_TOPIC')) {
            echo '<h4><a href="/forum/topic/create">Create Topic</a></h4>';
          }
        }
      }
      echo '<div id="topics">';
      while ($topic = $res->fetch_array(MYSQL_ASSOC)) {
        echo '<div class="topic"><a href="/forum/topic/?id=' . $topic['id'] . '"><h2>' . $topic['title'] . '</h2></a></div>';
      }
      echo '</div>';
      $stmt->close();
      if (!is_null($id)) {
        $stmt = $mysqli->prepare("SELECT id, title FROM thread WHERE topic = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        echo '<h1>Threads</h1>';
        if (isset($_SESSION['user'])) {
          if (!is_null($id)) {
            echo '<h4><a href="/forum/thread/create/?id=' . $id . '">Create Thread</a></h4>';
          } else {
            echo '<h4><a href="/forum/thread/create">Create Thread</a></h4>';
          }
        }
        echo '<div id="threads">';
        while ($thread = $res->fetch_array(MYSQL_ASSOC)) {
          echo '<div class="thread"><a href="/forum/thread/?id=' . $thread['id'] . '"><h2>' . $thread['title'] . '</h2></a></div>';
        }
        echo '</div>';
      }
      ?>
    </div>
  </body>
</html>
