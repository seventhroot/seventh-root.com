<?php
include '../includes/user.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Games</title>
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
      ?>
      <h1>Coming soon!</h1>
      <table class="games">
        <tr>
          <td class="game"><img src="/static/images/games/immaterial-realm.png"></td>
          <td class="game"><img src="/static/images/games/harmonic-moon.png"></td>
        </tr>
      </table>
    </div>
  </body>
</html>
