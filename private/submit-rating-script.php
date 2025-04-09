<?php
//used by submit-rating.js to insert/update ratings through ajax

require_once('initialize.php');

// Check if logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $gameid = $_POST['gameid'];
    // Check if rating select has been set
    if (!empty($_POST['rating'])) {

        // Check if there is any rows for this game and this user
        $rating_query_str = "SELECT * FROM `Ratings` WHERE game_id = $gameid AND username = '$username' ";
        // Execute the query 
        $res = mysqli_query($db, $rating_query_str);
        // Check if there are any results
        $isRating = NULL;
        $ratingID = NULL;
        $Rating = NULL;
        if (mysqli_num_rows($res) == 0) {
            $isRating = FALSE; // User has not yet set a rating
        } else {
            $isRating = TRUE; // User has a rating for this game
            while ($row = $res->fetch_assoc()) {
                $ratingID = $row['rating_id'];
                $Rating = $row['rating_num'];
            }
        }
        // Free the result 
        $res->free_result();

        // If user does not have a rating for this game, insert a new rating
        if ($isRating == FALSE) {
            //referenced prepared statements: https://www.w3schools.com/php/php_mysql_prepared_statements.asp
            $insert_str = $db->prepare("INSERT INTO Ratings (rating_num, rating_date, game_id, username) VALUES (?, ?, ?, ?)");
            //referenced date/time from: https://www.w3schools.com/php/php_date.asp
            $insert_str->bind_param("ssis", $rating, $datetime, $gameid, $username);

            $rating = $_POST['rating'];
            $datetime = date("Y-m-d") . " " . date("H:i:s");
            $gameid = $_POST['gameid'];
            $username = $_SESSION['username'];

            $insert_str->execute();

            echo "Success: Rating submitted!";
        } else { // Update the existing rating instead of reating a new row
            $update_str = "UPDATE Ratings SET rating_num = ? WHERE rating_id = ?";
            $statement = mysqli_prepare($db, $update_str);
            if (!$statement) {
                die("Error is: " . mysqli_error($db));
            }
            mysqli_stmt_bind_param($statement, 'ii', $rating, $ratingID);
            $rating = $_POST['rating'];
            // Execute the update
            mysqli_stmt_execute($statement);
            echo "Success: Existing rating was found, your rating has been updated!";
        }
    } else {
        // Give error that comment box must not be empty
        echo "Error: Please select a rating!";
    }

}
?>