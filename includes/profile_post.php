<?php
include_once 'user.php';
include_once 'database_settings.php';

class ProfilePost {

  private $id;
  private $profile;
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

  public function get_profile() {
    return get_user_by_id($this->profile);
  }

  public function set_profile($profile) {
    $this->profile = $profile->get_id();
  }

  public function get_reply_to() {
    return get_profile_post_by_id($this->reply_to);
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

function get_profile_post_by_id($id) {
  $mysqli = new mysqli(get_db_host(), get_db_user(), get_db_password(), get_db_database());
  $stmt = $mysqli->prepare("SELECT id, profile, reply_to, user, text, timestamp FROM profile_post WHERE id = ? LIMIT 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $post = new ProfilePost();
  	$post->set_id($row['id']);
    $post->set_profile(get_user_by_id($row['profile']));
    if (!is_null($row['reply_to'])) {
      $post->set_reply_to(get_profile_post_by_id($row['reply_to']));
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

function create_profile_post($profile, $user, $text, $reply_to=NULL) {
  $mysqli = new mysqli(get_db_host(), get_db_user(), get_db_password(), get_db_database());
  if (is_null($reply_to)) {
    $stmt = $mysqli->prepare("INSERT INTO profile_post(profile, user, text) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $profile->get_id(), $user->get_id(), $text);
    $stmt->execute();
    $stmt->close();
  } else {
    $stmt = $mysqli->prepare("INSERT INTO profile_post(profile, reply_to, user, text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $profile->get_id(), $reply_to->get_id(), $user->get_id(), $text);
    $stmt->execute();
    $stmt->close();
  }
  return $mysqli->insert_id;
}

function print_profile_posts($profile) {
  $mysqli = new mysqli(get_db_host(), get_db_user(), get_db_password(), get_db_database());
  $stmt = $mysqli->prepare("SELECT id, profile, reply_to, user, text, timestamp FROM profile_post WHERE profile = ? AND reply_to IS NULL ORDER BY timestamp DESC");
  $stmt->bind_param("i", $profile->get_id());
  $stmt->execute();
  $res = $stmt->get_result();
  while ($row = $res->fetch_array(MYSQL_ASSOC)) {
    $post = new ProfilePost();
  	$post->set_id($row['id']);
    $post->set_profile(get_user_by_id($row['profile']));
    if (!is_null($row['reply_to'])) {
      $post->set_reply_to(get_profile_post_by_id($row['reply_to']));
    }
    $post->set_user(get_user_by_id($row['user']));
    $post->set_text($row['text']);
    $post->set_timestamp($row['timestamp']);
    print_profile_post($post);
  }
  $stmt->close();
}

function print_profile_post($profile_post) {
  $profile_id = $profile_post->get_profile()->get_id();
  $mysqli = new mysqli(get_db_host(), get_db_user(), get_db_password(), get_db_database());
  $stmt = $mysqli->prepare("SELECT profile_post.id AS post_id, profile_post.user AS user_id, profile_post.text AS post_text, user.name AS user_name, user.email AS user_email FROM profile_post, user WHERE profile_post.id = ? AND profile_post.user = user.id ORDER BY timestamp");
  $stmt->bind_param("i", $profile_post->get_id());
  $stmt->execute();
  $res = $stmt->get_result();
  while ($post = $res->fetch_array(MYSQL_ASSOC)) {
    $gravatar_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($post['user_email']))) . "?s=64";
    echo '<table class="post">';
    echo '<tr>';
    echo '<td class="post-userinfo"><img src="' . $gravatar_url . '"><br />' . $post['user_name'] . '</td>';
    echo '<td class="post-content">' . $post['post_text'] . '</td>';
    echo '</tr>';
    if (isset($_SESSION['user'])) {
      echo '<tr>';
      echo '<td class="post-buttons" colspan=2>';
      echo '<form action="/profile/processpost/?id=' . $profile_id . '" method="POST">';
      echo '<textarea class="profile-reply" name="post"></textarea><br />';
      echo '<input value="Reply" type="submit"><br />';
      echo '<input type="hidden" name="reply_to" value="' . $post['post_id'] . '">';
      echo '</form>';
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
    $repliesstmt = $mysqli->prepare("SELECT id FROM profile_post WHERE reply_to = ?");
    $repliesstmt->bind_param("i", $profile_post->get_id());
    $repliesstmt->execute();
    $repliesres = $repliesstmt->get_result();
    if ($repliesres->num_rows > 0) {
      echo '<div class="replies">';
      while ($reply = $repliesres->fetch_array(MYSQL_ASSOC)) {
        print_profile_post(get_profile_post_by_id($reply['id']));
      }
      echo '</div>';
    }
    $repliesstmt->close();
  }
  $stmt->close();
}
?>
