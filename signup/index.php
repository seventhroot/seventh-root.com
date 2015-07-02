<?php
include '../includes/user.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Sign up</title>
    <?php include '../includes/stylesheets.php'; ?>
  </head>
  <body>
    <div id="main">
      <?php
      include '../includes/logo.php';
      if (isset($_SESSION['user'])) {
        include '../includes/navigation.php';
        echo 'You are already logged in!';
      } else {
        include '../includes/navigation_beforelogin.php';
        include '../includes/signup_form.php';
      }
      ?>
    </div>
  </body>
</html>
