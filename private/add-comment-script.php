<?php
// Used by add-comment.js to insert/update ratings through ajax

require_once('initialize.php');

// Check if logged in
if (isset($_SESSION['username'])) {
    // Check if comment box has text in it
    if (!empty($_POST['comment'])) {
        // Save user comment
        //referenced prepared statements: https://www.w3schools.com/php/php_mysql_prepared_statements.asp
        $insert_str = $db->prepare("INSERT INTO Comments (comment_desc, comment_date, game_id, username) VALUES (?, ?, ?, ?)");
        //referenced date/time from: https://www.w3schools.com/php/php_date.asp
        $insert_str->bind_param("ssis", $comment, $datetime, $gameid, $username);

        $comment = $_POST['comment'];
        $datetime = date("Y-m-d") . " " . date("H:i:s");
        $gameid = $_POST['gameid'];
        $username = $_SESSION['username'];
        $insert_str->execute();
        echo "Success! Comment posted.";
    } else {
        // Give error that comment box must not be empty
        echo "Error: Comment box cannot be empty.";
    }
} else {
    // If not logged in, throw error that user must make an account or sign in.
    echo "Error: Log in to leave comments!";
}
?>