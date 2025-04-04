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
                <?php  echo "<h2 class=\"\">" . $_SESSION['username'] . "</h2>"; ?> <!-- Display username -->
            </div>
        </div>
        <div id="userstats">
            <div class="userstats-container">
            <?php
                echo "<h3>Owned: </h3>";
                echo "<h3>Rated: </h3>";

                 // Loop through comments
                 $comments_query = "SELECT * 
                 FROM Comments
                 WHERE username = '". $_SESSION['username'] . "'";

                // Execute the query 
                $res = mysqli_query($db, $comments_query);
                // Check if there are any results
                if (mysqli_num_rows($res) == 0 ){
                    echo "<h3>Commented: 0</h3>";
                }else if(mysqli_num_rows($res) != 0) {
                    echo "<h3>Commented: " . mysqli_num_rows($res) . "</h3>";
                }
                $res -> free_result();

                // Loop through comments
                $collections_query = "SELECT * 
                FROM Collections
                WHERE username = '". $_SESSION['username'] . "'";

                // Execute the query 
                $res = mysqli_query($db, $collections_query);
                // Check if there are any results
                if (mysqli_num_rows($res) == 0 ){
                    echo "<h3>Collections: 0</h3>";
                }else if(mysqli_num_rows($res) != 0) {
                    echo "<h3>Collections: " . mysqli_num_rows($res) . "</h3>";
                }
                $res -> free_result();
            ?>
            <!-- settings page button?? -->
            </div>
        </div>
    </div>

    <div class="flex row border-top profile-body">
        <div class="border-right">
            <div class="activity-collections-container recent-activity">
                <h3>Recent Activity</h3>
    
                <?php
                // Loop through comments
                 $comments_query = "SELECT * 
                 FROM Comments
                 WHERE username = '". $_SESSION['username'] . "'";

                // Execute the query 
                $res = mysqli_query($db, $comments_query);
                // Check if there are any results
                if (mysqli_num_rows($res) == 0 ){
                    echo "<div class=\"flex row activity\">";
                        echo "<p>No activity yet!</p>";
                    echo "</div>";   
                }else if(mysqli_num_rows($res) != 0) {
                    while($row= mysqli_fetch_assoc($res)){
                        echo "<div class=\"flex row activity\">";
                            echo "<p>Commented on</p>";

                            $game_query = "SELECT names, game_id
                            FROM BoardGames
                            WHERE game_id =" . $row['game_id'];
        
                            $name = mysqli_query($db, $game_query);
                            
                            if(mysqli_num_rows($name) == 0){
                                echo "<p>Name not found</p>";
                            }else{
                                while($gameinfo= mysqli_fetch_assoc($name)){
                                    echo "<a href=\"". url_for('BoardGameSite/viewboardgame.php?gameid=') . $gameinfo['game_id'] ."\">". $gameinfo['names'] ."</a>";
                                    echo "<img src=\"./imgs/arrow-right.svg\">";
                                }
                            }
                            
                        echo "</div>";   
                    }
                }
                $res -> free_result();

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
                    WHERE username = '". $_SESSION['username'] . "'";

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
                                }else{
                                    echo "<img class=\"collection-icon\" src=\"./imgs/heart-outline.svg\">";
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