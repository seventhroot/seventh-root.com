<?php
include 'includes/user.php';
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Seventh Root - Home</title>
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
      <div class="container">
        <h1>Welcome!</h1>
        Welcome to Seventh Root gaming community.
        We are a friendly community that plays (and makes) games.
        Sign up and join us today!
      </div>
      <div class="container">
        <h1><span class="fa fa-headphones fa-lg"></span> Mumble</h1>
        <a href="mumble://seventh-root.com/General/General%20%5B1%5D%20-%20Ignis?title=Seventh%20Root&version=1.2.0">seventh-root.com</a><br />
        <iframe src="/MumPI/viewer/index.php?serverId=1"></iframe>
      </div>
      <div class="container">
        <h1><span class="fa fa-steam-square fa-lg"></span> Steam</h1>
        <a href="http://steamcommunity.com/groups/seventh-root">steamcommunity.com/groups/seventh-root</a>
      </div>
      <div class="container">
        <h1><span class="fa fa-github fa-lg"></span> GitHub</h1>
        <a href="https://github.com/seventhroot/">github.com/seventhroot</a>
      </div>
      <div class="container">
        <h1><span class="fa fa-comment fa-lg"></span> IRC</h1>
        <a href="irc://chat.freenode.net/seventhroot">#seventhroot on freenode</a>
      </div>
    </div>
  </body>
</html>
