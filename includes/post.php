<?php
include_once 'user.php';
include_once 'thread.php';
include_once 'database_settings.php';

class Post {

  private $id;
  private $thread;
  private $reply_to;
  private $user;
  private $text;
  private $timestamp;

  public function get_id() {
    return $this->id;
  }

  public function set_id($id) {
    $this->id = $id;
    return $this;
  }

  public function get_thread() {
    return get_thread_by_id($this->thread);
  }

  public function set_thread($thread) {
    $this->thread = $thread->get_id();
    return $this;
  }

  public function get_reply_to() {
    return get_post_by_id($this->reply_to);
  }

  public function set_reply_to($reply_to) {
    $this->reply_to = $reply_to->get_id();
    return $this;
  }

  public function get_user() {
    return $this->user;
  }

  public function set_user($user) {
    $this->user = $user->get_id();
    return $this;
  }

  public function get_text() {
    return $this->text;
  }

  public function set_text($text) {
    $this->text = $text;
    return $this;
  }

  public function get_timestamp() {
    return $this->timestamp;
  }

  public function set_timestamp($timestamp) {
    $this->timestamp = $timestamp;
    return $this;
  }

}

function get_post_by_id($id) {
  $mysqli = new mysqli(get_db_host(), get_db_user(), get_db_password(), get_db_database());
  $stmt = $mysqli->prepare("SELECT id, thread, reply_to, user, text, timestamp FROM post WHERE id = ? LIMIT 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $post = new Post();
  	$post->set_id($row['id']);
    $post->set_thread(get_thread_by_id($row['thread']));
    if (!is_null($row['reply_to'])) {
      $post->set_reply_to(get_post_by_id($row['reply_to']));
    }
    $post->set_user(get_user_by_id($row['user']));
    $post->set_text($row['text']);
    $post->set_timestamp($row['timestamp']);
  	$stmt->close();
  	return $post;
  } else {
    return NULL;
  }
}

function create_post($thread, $user, $text, $reply_to=NULL) {
  $mysqli = new mysqli(get_db_host(), get_db_user(), get_db_password(), get_db_database());
  if (is_null($reply_to)) {
    $stmt = $mysqli->prepare("INSERT INTO post(thread, user, text) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $thread->get_id(), $user->get_id(), $text);
    $stmt->execute();
    $stmt->close();
  } else {
    $stmt = $mysqli->prepare("INSERT INTO post(thread, reply_to, user, text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $thread->get_id(), $reply_to->get_id(), $user->get_id(), $text);
    $stmt->execute();
    $stmt->close();
  }
  return $mysqli->insert_id;
}

?>
