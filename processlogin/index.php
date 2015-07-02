<?php
include '../includes/user.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Login</title>
    <?php include '../includes/stylesheets.php'; ?>
  </head>
  <body>
    <div id="main">
      <?php
      include '../includes/logo.php';
      $message = '';
      if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = get_user_by_name($username);
        if (!is_null($user)) {
          if ($user->check_password($password)) {
            $_SESSION['user'] = $user;
            $message = 'Login successful.';
          } else {
            $message = 'Failed to login. Please <a href="/login">try again.</a>';
          }
        } else {
          $message = 'That user does not exist. Please <a href="/login">try again.</a>';
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
