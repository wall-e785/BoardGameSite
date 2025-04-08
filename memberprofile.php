<!DOCTYPE html>
<html lang="en">

<body>
    <?php
        require('header.php');
        require_once('private/initialize.php');
    ?>
    <div class="body">
    
    <div class="profile-header">
        <div class="border-right" id="username">
            <div class="username">
                <!-- add user profile image?? -->
                <?php  echo "<h2>" . $_GET['user'] . "</h2>"; ?> <!-- Display username -->
            </div>
        </div>
        <div id="userstats">
            <div class="userstats-container">
            <?php

                //referenced this to review nested queries https://learnsql.com/blog/sql-nested-select/
                //select all of the games that belong to the user's owned collection.
                //nested query retrives the collection_id of the owned collection, then referenced
                //by the main query to count how many entries in BelongTo have that collection_id
                $owned_query = "SELECT BelongTo.collection_id
                FROM BelongTo
                WHERE BelongTo.collection_id IN (
                    SELECT collection_id
                    FROM Collections
                    WHERE username = '". $_GET['user'] . "' AND collection_name = 'Owned')";

                //Execute the query
                $owned_res = mysqli_query($db, $owned_query);

                // Check if there are any results
                if (mysqli_num_rows($owned_res) == 0 ){
                    echo "<h3>Owned: 0</h3>";
                }else if(mysqli_num_rows($owned_res) != 0) {
                    echo "<h3>Owned: " . mysqli_num_rows($owned_res) . "</h3>";
                }

                 // Loop through ratings
                 $ratings_query = "SELECT rating_id 
                 FROM Ratings
                 WHERE username = '". $_GET['user'] . "'";

                // Execute the query 
                $rating_res = mysqli_query($db, $ratings_query);
                // Check if there are any results
                if (mysqli_num_rows($rating_res) == 0 ){
                    echo "<h3>Rated: 0</h3>";
                }else if(mysqli_num_rows($rating_res) != 0) {
                    echo "<h3>Rated: " . mysqli_num_rows($rating_res) . "</h3>";
                }
                $rating_res -> free_result();

                 // Loop through comments
                 $comments_query = "SELECT comment_id 
                 FROM Comments
                 WHERE username = '". $_GET['user'] . "'";

                // Execute the query 
                $comment_res = mysqli_query($db, $comments_query);
                // Check if there are any results
                if (mysqli_num_rows($comment_res) == 0 ){
                    echo "<h3>Commented: 0</h3>";
                }else if(mysqli_num_rows($comment_res) != 0) {
                    echo "<h3>Commented: " . mysqli_num_rows($comment_res) . "</h3>";
                }
                $comment_res -> free_result();

                // Loop through comments
                $collections_query = "SELECT * 
                FROM Collections
                WHERE username = '". $_GET['user'] . "'";

                // Execute the query 
                $res = mysqli_query($db, $collections_query);
                // Check if there are any results
                if (mysqli_num_rows($res) == 0 ){
                    echo "<h3>Collections: 0</h3>";
                }else if(mysqli_num_rows($res) != 0) {
                    echo "<h3>Collections: " . mysqli_num_rows($res) . "</h3>";
                }
                $res -> free_result();

                // Only display settings page button if logged in
                if(isset($_SESSION['username'])){
                    // If current user is the same as this user page
                    if($_SESSION['username']==$_GET['user']){
                        echo "<a class=\"settings-page-button\" href=\"settings.php?username=".$_SESSION['username']."\">Settings</a>";
                    }
                }
            ?>
                
            <!-- settings page button?? -->
            </div>
        </div>
    </div>

    <div class="border-top profile-body">
        <div class="border-right">
            <div class="activity-collections-container recent-activity">
                <h3>Recent Activity</h3>
    
                <?php
                //referenced sql order by date here: https://stackoverflow.com/questions/24567274/sql-order-by-datetime-desc
                //referenced unioning tables from: https://www.w3schools.com/sql/sql_ref_union_all.asp
                // Select from comments, then union the selection from ratings. Use variable type to keep track of which is which
                $recent_query = "SELECT * FROM (SELECT username, comment_id AS id, comment_date AS created, game_id, 'comment' AS type
                FROM Comments
                UNION ALL
                SELECT username, rating_id AS id, rating_date AS created, game_id, 'rating' AS type
                FROM Ratings) AS combined_recent
                WHERE combined_recent.username = '". $_GET['user'] . "'
                ORDER BY created DESC
                LIMIT 10";

                // Execute the query 
                $recent_res = mysqli_query($db, $recent_query);

                // Check if there are any results
                if (mysqli_num_rows($recent_res) == 0){
                    echo "<div class=\"activity\">";
                        echo "<p>No activity yet!</p>";
                    echo "</div>";   
                }else if(mysqli_num_rows($recent_res) != 0) {
                    while($row= mysqli_fetch_assoc($recent_res)){
                        echo "<div class=\"activity\">";
                            echo "<div>";
                                // Date
                                $dates = explode(" ", $row['created']); // Date, no time stamp
                                echo "<p>".$dates[0]."</p>";
                            echo "</div>";
                            echo "<div class=\"activity-name\">";
                            
                                $game_query = "SELECT names, game_id
                                FROM BoardGames
                                WHERE game_id =" . $row['game_id'];
            
                                $name = mysqli_query($db, $game_query);
                                
                                if(mysqli_num_rows($name) == 0){
                                    echo "<p>Name not found</p>";
                                }else{
                                    while($gameinfo= mysqli_fetch_assoc($name)){
                                        //display proper header depending on the activity type
                                        if($row['type'] == 'comment'){
                                            echo "<p class=\"activity-game-name\" >Commented on <a href=\"". url_for('BoardGameSite/viewboardgame.php?gameid=') . $gameinfo['game_id'] ."\">". $gameinfo['names'] ."</a></p>";
                                        }else if($row['type'] == 'rating'){
                                            echo "<p class=\"activity-game-name\">Rated <a href=\"". url_for('BoardGameSite/viewboardgame.php?gameid=') . $gameinfo['game_id'] ."\">". $gameinfo['names'] ."</a></p>";
                                        }
                                        // echo "<a href=\"". url_for('BoardGameSite/viewboardgame.php?gameid=') . $gameinfo['game_id'] ."\">". $gameinfo['names'] ."</a>";
                                        echo "<img src=\"./imgs/arrow-right.svg\">";
                                    }
                                }
                                


                            echo "</div>";
                        echo "</div>";  
                    }
                }
                $recent_res -> free_result();


                ?>
            </div>
        </div>
        <div>
            <div class="activity-collections-container">
            <h3>Collections</h3>
            <div class="collections-container">
                <?php
                    // Loop through comments
                    $collections_query = "SELECT collection_name, collection_id 
                    FROM Collections
                    WHERE username = '". $_GET['user'] . "'";

                    // Execute the query 
                    $res = mysqli_query($db, $collections_query);
                    // Check if there are any collections to display
                    if (mysqli_num_rows($res) != 0 ){
                        while($row= mysqli_fetch_assoc($res)){
                            echo "<div class=\"collection-preview\">";
                                echo "<div class=\"collection-img\">";
                                if ($row["collection_name"] == "Owned"){
                                    echo "<img class=\"collection-icon\" src=\"./imgs/star-filled.svg\">";
                                }else if($row["collection_name"] == "Wishlist"){
                                    echo "<img class=\"collection-icon\" src=\"./imgs/bookmark-filled.svg\">";
                                }else if($row["collection_name"] == "Favourites"){
                                    echo "<img class=\"collection-icon\" src=\"./imgs/heart-filled.svg\">";
                                }
                                echo "</div>";
                                echo "<a href=\"" . url_for('BoardGameSite/collectionpage.php') . "?collectionid=" . $row['collection_id'] . "&name=" . $row['collection_name'] . "\">" . $row['collection_name'] ."</a>";
                            echo "</div>"; 
                        }
                        $res->free_result();
                    }
                ?>
                <div class="collection-preview">
                    <div class="collection-img">
                        <img class="collection-icon" src="./imgs/plus-filled.svg">
                    </div>
                    <?php
                        echo "<a href=\"" . url_for('BoardGameSite/makecollection.php') . "\">New Collection</a>";
                    ?>
                </div>
            </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>