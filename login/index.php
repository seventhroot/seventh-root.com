<?php
include '../includes/user.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Login</title>
    <script type="application/javascript" src="/static/js/jquery-2.1.4.min.js"></script>
    <script type="application/javascript" src="/static/js/jquery.chroma-hash.min.js"></script>
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
        include '../includes/login_form.php';
        echo 'Don\'t have an account yet? <a href="/signup">Create an account</a>';
      }
      ?>
    </div>
  </body>
</html>
