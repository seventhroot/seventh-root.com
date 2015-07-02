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
      if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $message = '';
        if (!is_null(get_user_by_name($username))) {
          $message = 'A user by that name already exists. <a href="/signup">Choose a different username.</a>';
        } else {
          create_user($username, $email, $password);
          $message = 'User created. You may now <a href="/login">login.</a>';
        }
      } else {
        $message = 'Invalid request. Please <a href="/signup">try again</a>.';
      }
      if (isset($_SESSION['user'])) {
        include '../includes/navigation.php';
      } else {
        include '../includes/navigation_beforelogin.php';
      }
      echo $message;
      ?>
    </div>
  </body>
</html>
