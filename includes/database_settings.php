<?php
$database_settings = parse_ini_file("database.ini");
function get_db_host() {
  return $database_settings['host'];
}

function get_db_user() {
  return $database_settings['user'];
}

function get_db_password() {
  return $database_settings['password'];
}

function get_db_database() {
  return $database_settings['database'];
}
?>
