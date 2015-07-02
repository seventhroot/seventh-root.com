<?php
function print_reply_form($thread_id, $post_id) {
  echo '<form action="/forum/thread/processreply/?id=' . $thread_id . '" method="POST">' . "\n";
  echo '  <textarea name="reply"></textarea><br />' . "\n";
  echo '  <input value="Reply" type="submit"><br />' . "\n";
  echo '  <input type="hidden" name="post_id" value="' . $post_id . '">' . "\n";
  echo '</form>' . "\n";
}
?>
