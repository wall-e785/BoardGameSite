<!--used to display a collection-->
<!DOCTYPE html>
<html lang="en">

<body>
    <div class="body">


    <?php

    require('header.php');
    require_once('private/initialize.php');

    $name = $_GET['name']; 


    echo "<div class=\"flex row\">";
    echo "<h2>" . $name ."</h2>";
    echo "</div>";
    ?>

        <div class="flex row">
            <h3>2. Select Games (Optional)</h3>
        </div>

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

