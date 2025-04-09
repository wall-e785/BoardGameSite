<?php
//removes games from a collection
require_once('private/initialize.php');

$delete_str = $db->prepare("DELETE FROM BelongTo WHERE collection_id = ? AND game_id = ?");
$delete_str->bind_param("ii", $collection_id, $game_id);

$collection_id = $_GET['collectionid'];
$game_id = $_GET['gameid'];
$delete_str->execute();

redirect_to(url_for('BoardGameSite/collectionpage.php?collectionid=') . $collection_id . '&name=' . $_GET['name']);
?>