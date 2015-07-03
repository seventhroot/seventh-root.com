<?php
class User {

  private $id;
  private $name;
  private $email;
  private $password_hash;

  public function get_id() {
    return $this->id;
  }

  public function set_id($id) {
    $this->id = $id;
    return $this;
  }

  public function get_name() {
    return $this->name;
  }

  public function set_name($name) {
    $this->name = $name;
    return $this;
  }

  public function get_email() {
    return $this->email;
  }

  public function set_email($email) {
    $this->email = $email;
    return $this;
  }

	public function get_password_hash() {
		return $this->password_hash;
	}

  public function set_password_hash($password_hash) {
    $this->password_hash = $password_hash;
    return $this;
  }

  public function set_password($password) {
    $this->password_hash = password_hash($password, PASSWORD_BCRYPT);
    return $this;
  }

  public function check_password($password) {
		return password_verify($password, $this->get_password_hash());
  }

}

function get_user_by_id($id) {
  $mysqli = new mysqli("localhost", "seventhroot", "mN6?XdL)%jK", "seventhroot");
  $stmt = $mysqli->prepare("SELECT id, name, email, password_hash FROM user WHERE id = ? LIMIT 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $user = new User();
  	$user->set_id($row['id']);
  	$user->set_name($row['name']);
  	$user->set_email($row['email']);
  	$user->set_password_hash($row['password_hash']);
  	$stmt->close();
  	return $user;
  } else {
    return NULL;
  }
}

function get_user_by_name($name) {
  $mysqli = new mysqli("localhost", "seventhroot", "mN6?XdL)%jK", "seventhroot");
  $stmt = $mysqli->prepare("SELECT id, name, email, password_hash FROM user WHERE name = ? LIMIT 1");
  $stmt->bind_param("s", $name);
  $stmt->execute();
  $res = $stmt->get_result();
	if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $user = new User();
  	$user->set_id($row['id']);
  	$user->set_name($row['name']);
  	$user->set_email($row['email']);
  	$user->set_password_hash($row['password_hash']);
  	$stmt->close();
  	return $user;
  } else {
    return NULL;
  }
}

function create_user($name, $email, $password) {
  if (is_null(get_user_by_name($name))) {
    $user = new User();
    $user->set_name($name)->set_email($email)->set_password($password);
    $mysqli = new mysqli("localhost", "seventhroot", "mN6?XdL)%jK", "seventhroot");
    $stmt = $mysqli->prepare("INSERT INTO user(name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user->get_name(), $user->get_email(), $user->get_password_hash());
    $stmt->execute();
    $stmt->close();
  }
}
?>
