
<?php
    //removes comments from a game
    require_once('private/initialize.php');

    $delete_str = $db -> prepare("DELETE FROM Comments WHERE comment_id = ?");
    $delete_str->bind_param("i", $commentid);
    $commentid = $_GET['commentid'];
    $delete_str->execute();           

    redirect_to(url_for('BoardGameSite/viewboardgame.php?gameid=') . $_GET["gameid"]);
?>