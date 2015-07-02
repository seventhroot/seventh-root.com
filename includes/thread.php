<?php
include_once 'user.php';
include_once 'topic.php';

class Thread {

  private $id;
  private $title;
  private $topic;

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

  public function get_topic() {
    return get_topic_by_id($this->topic);
  }

  public function set_topic($topic) {
    $this->topic = $topic->get_id();
    return $this;
  }

  public function draw() {
    $mysqli = new mysqli("localhost", "seventhroot", "mN6?XdL)%jK", "seventhroot");
    $stmt = $mysqli->prepare("SELECT post.id AS post_id, post.user AS user_id, post.text AS post_text, user.name AS user_name, user.email AS user_email FROM post, user WHERE post.reply_to IS NULL AND post.thread = ? AND post.user = user.id ORDER BY timestamp DESC");
    $stmt->bind_param("i", $this->get_id());
    $stmt->execute();
    $res = $stmt->get_result();
    while ($post = $res->fetch_array(MYSQL_ASSOC)) {
      $gravatar_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($post['user_email']))) . "?s=64";
      echo '<table class="post">';
      echo '<tr>';
      echo '<td class="post-userinfo"><img src="' . $gravatar_url . '"><br /><a href="/profile/?id=' . $post['user_id'] . '">' . $post['user_name'] . '</a></td>';
      echo '<td class="post-content">' . $post['post_text'] . '</td>';
      echo '</tr>';
      if (isset($_SESSION['user'])) {
        echo '<tr>';
        echo '<td class="post-buttons" colspan=2>';
        echo '<a href="/forum/thread/reply/?thread_id=' . $this->get_id() . '&post_id=' . $post['post_id'] .'"><span class="fa fa-reply post-button"></span></a>';
        echo '</td>';
        echo '</tr>';
      }
      echo '</table>';
      $repliesstmt = $mysqli->prepare("SELECT id FROM post WHERE reply_to = ?");
      $repliesstmt->bind_param("i", $post['post_id']);
      $repliesstmt->execute();
      $repliesres = $repliesstmt->get_result();
      if ($repliesres->num_rows > 0) {
        echo '<div class="replies">';
        while ($reply = $repliesres->fetch_array(MYSQL_ASSOC)) {
          $this->draw_post($reply['id']);
        }
        echo '</div>';
      }
      $repliesstmt->close();
    }
    $stmt->close();
  }

  public function draw_post($post_id) {
    $thread_id = $this->get_id();
    $mysqli = new mysqli("localhost", "seventhroot", "mN6?XdL)%jK", "seventhroot");
    $stmt = $mysqli->prepare("SELECT post.id AS post_id, post.user AS user_id, post.text AS post_text, user.name AS user_name, user.email AS user_email FROM post, user WHERE post.id = ? AND post.user = user.id ORDER BY timestamp DESC");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($post = $res->fetch_array(MYSQL_ASSOC)) {
      $gravatar_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($post['user_email']))) . "?s=64";
      echo '<table class="post">';
      echo '<tr>';
      echo '<td class="post-userinfo"><img src="' . $gravatar_url . '"><br /><a href="/profile/?id=' . $post['user_id'] . '">' . $post['user_name'] . '</a></td>';
      echo '<td class="post-content">' . $post['post_text'] . '</td>';
      echo '</tr>';
      if (isset($_SESSION['user'])) {
        echo '<tr>';
        echo '<td class="post-buttons" colspan=2>';
        echo '<a href="/forum/thread/reply/?thread_id=' . $this->get_id() . '&post_id=' . $post_id . '"><span class="fa fa-reply post-button"></span></a>';
        echo '</td>';
        echo '</tr>';
      }
      echo '</table>';
      $repliesstmt = $mysqli->prepare("SELECT id FROM post WHERE reply_to = ?");
      $repliesstmt->bind_param("i", $post_id);
      $repliesstmt->execute();
      $repliesres = $repliesstmt->get_result();
      if ($repliesres->num_rows > 0) {
        echo '<div class="replies">';
        while ($reply = $repliesres->fetch_array(MYSQL_ASSOC)) {
          $this->draw_post($reply['id']);
        }
        echo '</div>';
      }
      $repliesstmt->close();
    }
    $stmt->close();
  }

  public function print_path() {
    echo ' &raquo; <a href="/forum">Forum</a>';
    if (!is_null($this->get_topic())) {
      $this->get_topic()->print_path(1);
    }
    echo ' &raquo; ' . $this->get_title() . "\n";
  }

}

function get_thread_by_id($id) {
  $mysqli = new mysqli("localhost", "seventhroot", "mN6?XdL)%jK", "seventhroot");
  $stmt = $mysqli->prepare("SELECT id, title, topic FROM thread WHERE id = ? LIMIT 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $thread = new Thread();
  	$thread->set_id($row['id']);
  	$thread->set_title($row['title']);
  	$thread->set_topic(get_topic_by_id($row['topic']));
  	$stmt->close();
  	return $thread;
  } else {
    return NULL;
  }
}

function get_thread_by_title($title) {
  $mysqli = new mysqli("localhost", "seventhroot", "mN6?XdL)%jK", "seventhroot");
  $stmt = $mysqli->prepare("SELECT id, title, topic FROM thread WHERE title = ? LIMIT 1");
  $stmt->bind_param("s", $title);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $thread = new Topic();
  	$thread->set_id($row['id']);
  	$thread->set_title($row['title']);
  	$thread->set_topic(get_topic_by_id($row['topic']));
  	$stmt->close();
  	return $topic;
  } else {
    return NULL;
  }
}

function create_thread($title, $topic) {
  $mysqli = new mysqli("localhost", "seventhroot", "mN6?XdL)%jK", "seventhroot");
  $stmt = $mysqli->prepare("INSERT INTO thread(title, topic) VALUES (?, ?)");
  $stmt->bind_param("si", $title, $topic->get_id());
  $stmt->execute();
  $stmt->close();
  return $mysqli->insert_id;
}
?>
