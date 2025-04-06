<!--used to display a collection-->
<!DOCTYPE html>
<html lang="en">

<body>
    <div class="body">


    <?php

        require('header.php');
    
        require_once('private/initialize.php');
        

        $name = $_GET['name']; 
        $collectionid = $_GET['collectionid'];

        $query = "SELECT username, collection_date
                        FROM Collections
                        WHERE collection_id =" . $collectionid;
        
        $res = mysqli_query($db, $query);

        if (mysqli_num_rows($res) > 0){
            $collection=mysqli_fetch_assoc($res);
            $collection_username = $collection['username'];
            $collection_date = substr($collection['collection_date'], 0, 10);

            // echo "<h3>Created by " . $collection['username'] . " on " . substr($collection['collection_date'], 0, 10) .  "</h3>";
        }

        
        // echo "</div>";
    ?>

    <div class="collection-header-container">
        <div class="collection-title-container border-right"> 
            <h2><?php echo $name; ?></h>
        </div>
        <div class="collection-createdby-container"> 
            <h3>Created by <?php echo $collection_username; ?> on <?php echo $collection_date; ?></h3>
        </div>
        <?php
            // Display edit/delete buttons only if logged in
            if(isset($_SESSION['username'])){
                echo "<div class=\"edit-delete-container border-left\">";
                if($name != "Owned" && $name != "Wishlist" && $name != "Favourites"){ 
                    // Displays delete button only for collections that are not Owned/Wishlist/Favourites
                    echo "<a href=\"" .  url_for('BoardGameSite/deletecollection.php' . "?collectionid=" . $_GET['collectionid']) . "\"><img class=\"collection-delete-img\" src=\"./imgs/delete.svg\"></a>"; 
                }
                    echo "<a class=\"edit-button\" href=\"edit-collection.php?name=".urlencode($name)."&collectionid=".urlencode($collectionid)."\">Edit</a>";
                echo "</div>";
            }
        ?>
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

