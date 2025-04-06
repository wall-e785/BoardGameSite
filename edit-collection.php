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

    <form class="collection-header-container" action='edit-collection.php'>
        <div class="collection-title-container border-right">
            <label class="labelAbove" for="collectionName">Collection Name:</label>
            <input class="edit-collection-title" type="text" name="collectionName" class="collection-name" value="<?php echo $name?>" /><br />
            <!-- Hidden field for collection ID -->
            <input type="hidden" name="collectionid" value="<?php echo $collectionid ?>" />
            
        </div>
        <div class="edit-delete-container">
            <input class="cancel-edit-button" type="submit" id="submit" value="Save"/>
            <a class="cancel-edit-button"<?php echo"href=\"javascript:history.go(-1)\" "; ?> >cancel</a>
        </div>
    </form>

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
                    $img_url = $game['image_url'];
                    $game_name = $game['names'];

                    echo "<div class=\"collection-gallery-item\">";
                        echo "<div class=\"\">";
                            echo "<img class=\"collection-gallery-img\" src=\"" . $img_url . "\">";
                        echo "</div>";
                        echo "<a class=\"collection-gallery-text\"href=\"". url_for('BoardGameSite/viewboardgame.php?gameid=') . $gameid ."\">". $game['names'] . "</a>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>

</body>
</html>


