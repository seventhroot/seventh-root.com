<?php
include_once 'database_settings.php';

class Topic {

  private $id;
  private $title;
  private $parent;

  public function get_id() {
    return $this->id;
  }

  public function set_id($id) {
    $this->id = $id;
    return $this;
  }

  public function get_title() {
    return $this->title;
  }

  public function set_title($title) {
    $this->title = $title;
    return $this;
  }

  public function get_parent() {
    return get_topic_by_id($this->parent);
  }

  public function set_parent($parent) {
    $this->parent = $parent->get_id();
    return $this;
  }

  public function print_path($recursions = 0) {
    if ($recursions === 0) {
      echo ' &raquo; <a href="/forum">Forum</a>';
    }
    if (!is_null($this->parent)) {
      $this->get_parent()->print_path($recursions + 1);
    }
    $title = $this->get_title();
    if ($recursions > 0) {
      echo ' &raquo; <a href="/forum/topic/?id=' . $this->get_id() . '">' . $this->get_title() . '</a>';
    } else {
      echo ' &raquo; ' . $this->get_title() . "\n";
    }
  }

}

function get_topic_by_id($id) {
  $mysqli = new mysqli(get_db_host(), get_db_user(), get_db_password(), get_db_database());
  $stmt = $mysqli->prepare("SELECT id, title, parent FROM topic WHERE id = ? LIMIT 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $topic = new Topic();
  	$topic->set_id($row['id']);
  	$topic->set_title($row['title']);
    $parent = get_topic_by_id($row['parent']);
  	if (!is_null($parent)) {
      $topic->set_parent($parent);
    }
  	$stmt->close();
  	return $topic;
  } else {
    return NULL;
  }
}

function get_topic_by_title($title) {
  $mysqli = new mysqli(get_db_host(), get_db_user(), get_db_password(), get_db_database());
  $stmt = $mysqli->prepare("SELECT id, title, parent FROM topic WHERE title = ? LIMIT 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $topic = new Topic();
  	$topic->set_id($row['id']);
  	$topic->set_title($row['title']);
  	$topic->set_parent(get_topic_by_id($row['parent']));
  	$stmt->close();
  	return $topic;
  } else {
    return NULL;
  }
}

function create_topic($title, $parent = NULL) {
  $mysqli = new mysqli(get_db_host(), get_db_user(), get_db_password(), get_db_database());
  if (is_null($parent)) {
    $stmt = $mysqli->prepare("INSERT INTO topic(title) VALUES (?)");
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $stmt->close();
  } else {
    $stmt = $mysqli->prepare("INSERT INTO topic(title, parent) VALUES (?, ?)");
    $stmt->bind_param("si", $title, $parent->get_id());
    $stmt->execute();
    $stmt->close();
  }
  return $mysqli->insert_id;
}
?>
