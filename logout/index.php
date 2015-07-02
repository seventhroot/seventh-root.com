<?php
include '../includes/user.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Logout</title>
    <?php include '../includes/stylesheets.php'; ?>
  </head>
  <body>
    <div id="main">
      <?php
      include '../includes/logo.php';
      include '../includes/navigation_beforelogin.php';
      if (isset($_SESSION['user'])) {
        echo 'Successfully logged out.';
      } else {
        echo 'You are not logged in!';
      }
      session_destroy();
      ?>
    </div>
  </body>
</html>
