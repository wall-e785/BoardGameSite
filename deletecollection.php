<?php
//removes comments from a game
require_once('private/initialize.php');

$delete_belong = $db->prepare("DELETE FROM BelongTo WHERE collection_id = ?");
$delete_belong->bind_param("i", $collectionid);

$delete_str = $db->prepare("DELETE FROM Collections WHERE collection_id = ?");
$delete_str->bind_param("i", $collectionid);

$collectionid = $_GET['collectionid'];
$delete_belong->execute();
$delete_str->execute();

redirect_to(url_for('Playtested/memberprofile.php?user=' . $_GET["username"]));
?>