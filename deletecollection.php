
<?php
    //removes comments from a game
    require_once('private/initialize.php');

    $delete_str = $db -> prepare("DELETE FROM Collections WHERE collection_id = ?");
    $delete_str->bind_param("i", $collectionid);
    $collectionid = $_GET['collectionid'];
    $delete_str->execute();           

    redirect_to(url_for('BoardGameSite/memberprofile.php'));
?>