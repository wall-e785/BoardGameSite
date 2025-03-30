<!DOCTYPE html>
<html lang="en">

<body>
    <?php
        require('header.php');
        require_once('private/initialize.php');
    ?>
    <div class="body">
    
    <div class="flex row">
        <div class="border-right" id="username">
            <div class="padding">
                <!-- add user profile image?? -->
                <?php  echo "<h2>" . $_SESSION['username'] . "</h2>"; ?>
            </div>
        </div>
        <div class="flex wrap" id="userstats">
            <div class="padding">
            <?php
                echo "<p>Owned: </p>";
                echo "<p>Rated: </p>";

                 // Loop through comments
                 $comments_query = "SELECT * 
                 FROM Comments
                 WHERE username = '". $_SESSION['username'] . "'";

                // Execute the query 
                $res = mysqli_query($db, $comments_query);
                // Check if there are any results
                if (mysqli_num_rows($res) == 0 ){
                    echo "<p>Commented: 0</p>";
                }else if(mysqli_num_rows($res) != 0) {
                    echo "<p>Commented: " . mysqli_num_rows($res) . "</p>";
                }
                $res -> free_result();
                echo "<p>Collections: </p>";
            ?>
            <!-- settings page button?? -->
            </div>
        </div>
    </div>

    <div class="flex row border-top profile-body">
        <div class="border-right">
            <div class="padding flex column">
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
                        echo "<img src=\"./imgs/arrow-right.svg\">";
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
            <div class="padding flex column">
            <h3>Collections</h3>
            <div class="flex wrap">
                <div class="collection-preview">
                    <div class="collection-img">
                        <img class="collection-icon" src="./imgs/bookmark-filled.svg">
                    </div>
                    <?php
                        echo "<a href=\"". url_for("BoardGameSite/collectionpage.php" ."\">Owned</a>")
                    ?>
                </div>
                <div class="collection-preview">
                    <div class="collection-img">
                        <img class="collection-icon" src="./imgs/star-filled.svg">
                    </div>
                    <h4>Wishlist<h4>
                </div>
                <div class="collection-preview">
                    <div class="collection-img">
                        <img class="collection-icon" src="./imgs/heart-filled.svg">
                    </div>
                    <h4>Favourites<h4>
                </div>
                <div class="collection-preview">
                    <div class="collection-img">
                        <img class="collection-icon" src="./imgs/plus-filled.svg">
                    </div>
                    <a>New Collection</a>
                </div>
            </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>