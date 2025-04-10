<?php
//removes comments from a game
require_once('private/initialize.php');

$delete_str = $db->prepare("DELETE FROM Comments WHERE comment_id = ?");
$delete_str->bind_param("i", $comment_id);

$comment_id = $_GET['commentid'];
$delete_str->execute();

redirect_to(url_for('Playtested/viewboardgame.php?gameid=' . $_GET['gameid']));
?>