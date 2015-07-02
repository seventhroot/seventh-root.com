<?php
include_once '../includes/user.php';
include_once '../includes/profile_post.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Profile</title>
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
      if (isset($_GET['id'])) {
        $user = get_user_by_id($_GET['id']);
        $gravatar_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim(get_user_by_id($_GET['id'])->get_email()))) . "?s=96";
        echo '<table class="profile-header">';
        echo '<tr>';
        echo '<td class="profile-avatar">';
        echo '<img src="' . $gravatar_url . '" />';
        echo '</td>';
        echo '<td class="profile-name">';
        echo '<h1>' . $user->get_name() . '</h1>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo '<form action="/profile/processpost/?id=' . $_GET['id'] . '" method="POST">';
        echo '<textarea name="post"></textarea><br />';
        echo '<input value="Post" type="submit"><br />';
        echo '</form>';
        print_profile_posts($user);
      }
      ?>
    </div>
  </body>
</html>
