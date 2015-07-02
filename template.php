<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - TEMPLATE CHANGE TITLE</title>
    <?php include 'includes/stylesheets.php'; ?>
  </head>
  <body>
    <div id="main">
      <?php
      include 'includes/logo.php';
      if (isset($_SESSION['user'])) {
        include 'includes/navigation.php';
      } else {
        include 'includes/navigation_beforelogin.php';
      }
      ?>
    </div>
  </body>
</html>
