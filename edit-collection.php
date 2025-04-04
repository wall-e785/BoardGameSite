<!--used to display a collection-->
<!DOCTYPE html>
<html lang="en">

<body>
    <div class="body">
    <?php
        require('header.php');
        include("./private/edit-collection-script.php");
        require_once('private/initialize.php');
        $name = $_GET['name']; 
        $collectionid = $_GET['collectionid'];
    ?>
        <?php echo"<a href=\"javascript:history.go(-1)\">"; ?>
        <div class="back-arrow centered ">
            <img class="collection-icon" src="./imgs/arrow-left.svg">
            <h6>cancel</h6>
        </div></a>


        <form action='edit-collection.php'>
            <div class="flex column">
                <h3>Edit Your Collection</h3>
                <label class="labelAbove" for="collectionName">Collection Name:</label>
                <input type="text" name="collectionName" class="collection-name" value="<?php echo $name?>" /><br />
                 <!-- Hidden field for collection ID -->
                <input type="hidden" name="collectionid" value="<?php echo $collectionid ?>" />
                <input type="submit" id="submit" value="Save"/>
            </div>
        </form>
    <?php
        $query = "SELECT username, collection_date
                        FROM Collections
                        WHERE collection_id =" . $collectionid;
        
        $res = mysqli_query($db, $query);    
        echo "</div>";
    ?>

        <div class="flex make-collection-wrap">
            <?php
            $boardgames = "SELECT game_id
                            FROM BelongTo
                            WHERE collection_id =" . $_GET['collectionid'];

            // Execute the query 
            $res = mysqli_query($db, $boardgames);
            // Check if there are any results
            if (mysqli_num_rows($res) == 0 ){
                echo "<h4>No games in this collection.</h4>";
            }else if(mysqli_num_rows($res) != 0) {
                while($row= mysqli_fetch_assoc($res)){
                    $gameid = $row['game_id'];

                    $gameinfo = "SELECT game_id, names, image_url 
                                FROM BoardGames
                                WHERE game_id ='" . $gameid . "'";

                    $select_game = mysqli_query($db, $gameinfo);
                    $game = mysqli_fetch_assoc($select_game);
                    echo "<div class=\"collection-preview\">";
                        echo "<div class=\"collection-preview\">";
                            echo "<img class=\"make-collection-img\" src=\"" . $game['image_url'] . "\">";
                        echo "</div>";
                        echo "<a href=\"". url_for('BoardGameSite/viewboardgame.php?gameid=') . $game['game_id'] ."\">". $game['names'] . "</a>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>

</body>
</html>


