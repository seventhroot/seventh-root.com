<?php include_once 'user.php' ?>
<div id="menu">
  <ul>
    <li><a href="/"><span class="fa fa-home"></span> Home</a></li>
    <li><a href="/forum"><span class="fa fa-comments"></span> Forum</a></li>
    <li><a href="/games"><span class="fa fa-gamepad"></span> Games</a></li>
    <li><a href="/profile/?id=<?php echo $_SESSION['user']->get_id(); ?>"><span class="fa fa-user"></span> Profile</a></li>
    <li><a href="/logout"><span class="fa fa-sign-out"></span> Logout</a></li>
  </ul>
</div>
