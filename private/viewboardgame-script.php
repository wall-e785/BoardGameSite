<?php
    // Retrieve game id from session variable if set
    // session_start(); 
    $gameid = null;
    // Retrieving the game id if it is not null. This was set on the viewboardgame.php file
    $gameid = $_SESSION['game_id'] ?? null;

    // Checking what the user submitted
    $errorsComments = [];
    // Check if comment submit button was pressed
    if (isset($_POST['post-comment'])){
        // Check if logged in
        if(isset($_SESSION['username'])) {
            // Check if comment box has text in it
            if(!empty($_POST['comment'])){ 
                // Save user comment
                //referenced prepared statements: https://www.w3schools.com/php/php_mysql_prepared_statements.asp
                $insert_str = $db -> prepare("INSERT INTO Comments (comment_desc, comment_date, game_id, username) VALUES (?, ?, ?, ?)");
                //referenced date/time from: https://www.w3schools.com/php/php_date.asp
                $insert_str->bind_param("ssis", $comment, $datetime, $gameid, $username);
                
                $comment = $_POST['comment'];
                $datetime = date("Y-m-d") . " " . date("H:i:s");
                $gameid = $_GET['gameid'];
                $username = $_SESSION['username'];
                $insert_str->execute();           
            }else{
                // Give error that comment box must not be empty
                array_push($errorsComments, 'Comment box must not be empty.');
            }
        }else{
            // If not logged in, throw error that user must make an account or sign in.
            array_push($errorsComments, 'Log in or make an account to leave a comment.');
        }
    } 
    // Unset the game id variable so that new game pages can be loaded!
    unset($_SESSION['game_id']);
?>