
<?php
    //removes comments from a game
    require_once('private/initialize.php');

    $update_str = $db -> prepare("UPDATE Comments SET comment_desc = ? WHERE comment_id = ?");
    $update_str->bind_param("si", $newComment, $commentid);
    $newComment = $_POST['newtext'];
    $commentid = $_POST['commentid'];
    $update_str->execute();           
?>