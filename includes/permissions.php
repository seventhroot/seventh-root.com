<?php
include_once 'database_settings.php';
function has_permission($user, $permission) {
  $mysqli = new mysqli(get_db_host(), get_db_user(), get_db_password(), get_db_database());
  $stmt = $mysqli->prepare("SELECT permission.permission FROM `user`, `group`, `user_group`, `permission` WHERE user.id = ? AND user_group.group_id = group.id AND user_group.user_id = user.id AND permission.group_id = group.id AND permission.permission = ?");
  $stmt->bind_param("is", $user->get_id(), $permission);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows > 0) {
    return true;
  } else {
    return false;
  }
}
?>
