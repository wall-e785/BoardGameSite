<?php
    // Retrieve game id from session variable if set
    // session_start(); 
    $gameid = null;
    // Retrieving the game id if it is not null. This was set on the viewboardgame.php file
    $gameid = $_SESSION['game_id'] ?? null;

    //Check if ratings exist for this user -------------------
    // is user logged in?
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        // Check if there is any rows for this game and this user
        $rating_query_str = "SELECT * FROM `Ratings` WHERE game_id = $gameid AND username = '$username' ";
        // Execute the query 
        $res = mysqli_query($db, $rating_query_str);
        // Check if there are any results
        $isRating = NULL;
        $ratingID = NULL;
        $Rating = NULL;
        if (mysqli_num_rows($res) == 0){
            $isRating = FALSE; // User has not yet set a rating
        }else{
            $isRating = TRUE; // User has a rating for this game
            while ($row = $res->fetch_assoc()) {
                $ratingID = $row['rating_id'];
                $Rating = $row['rating_num'];
            }
        }
        // Free the result 
        $res->free_result();
    } 

    // Checking what the user submitted
    $errorsRating = [];
    $errorsCollection = [];
    $errorsComments = [];
    if(is_post_request()) {
        // Check if rating submit button was pressed
        if (isset($_POST['rating-submit'])) {
            // Check if logged in
            if(isset($_SESSION['username'])) {
                // Check if rating select has been set
                if(!empty($_POST['rating'])){ 
                    // If user does not have a rating for this game, insert a new rating
                    if ($isRating == FALSE){
                        //referenced prepared statements: https://www.w3schools.com/php/php_mysql_prepared_statements.asp
                        $insert_str = $db -> prepare("INSERT INTO Ratings (rating_num, rating_date, game_id, username) VALUES (?, ?, ?, ?)");
                        //referenced date/time from: https://www.w3schools.com/php/php_date.asp
                        $insert_str->bind_param("ssis", $rating, $datetime, $gameid, $username);

                        $rating = $_POST['rating'];
                        $datetime = date("Y-m-d") . " " . date("H:i:s");
                        $gameid = $_GET['gameid'];
                        $username = $_SESSION['username'];
                        $insert_str->execute();  
                    }else{ // Update the existing rating instead of reating a new row
                        $update_str = "UPDATE Ratings SET rating_num = ? WHERE rating_id = ?";
                        $statement = mysqli_prepare($db, $update_str);
                        if (!$statement){
                            die("Error is: ".mysqli_error($db));
                        }
                        mysqli_stmt_bind_param($statement, 'ii', $rating, $ratingID);
                        $rating = $_POST['rating'];
                        // Execute the update
                        mysqli_stmt_execute($statement); 
                    }     
                }else{
                    // Give error that comment box must not be empty
                    array_push($errorsRating, 'Please select a rating.');
                }
    
            }else{
                // If not logged in, throw error that user must make an account or sign in.
                array_push($errorsRating, 'Log in or make an account to leave ratings.');
            }
        }
        // Check if rating submit button was pressed
        else if (isset($_POST['collection-submit'])){
            // Check if logged in
            if(isset($_SESSION['username'])) {
                // Check if add-to-collection select has been set
                if(!empty($_POST['add-to-collection'])){
                    //Retrieve string value of the name of the collection they want to add to
                    $selectedCollectionID = $_POST['add-to-collection']; 
                    $game_id = $_GET['gameid'];

                    $belongto_query = $db->prepare("INSERT INTO BelongTo (collection_id, game_id) VALUES (?, ?)");
                    $belongto_query->bind_param("ii", $selectedCollectionID, $game_id);

                    $belongto_query->execute();  

                }else{
                    // Give error that collection box must not be empty
                    array_push($errorsCollection, 'Please select a collection.');
                }
            }else{
                // If not logged in, throw error that user must make an account or sign in.
                array_push($errorsCollection, 'Log in or make an account to add to collections.');
            }
        }
        // Check if comment submit button was pressed
        else if (isset($_POST['post-comment'])){
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
                    array_push($errors, 'Comment box must not be empty.');
                }
            }else{
                // If not logged in, throw error that user must make an account or sign in.
                array_push($errors, 'Log in or make an account to leave a comment.');
            }
        }
    } 
    // Unset the game id variable so that new game pages can be loaded!
    unset($_SESSION['game_id']);
?>