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

        if (mysqli_num_rows($res) > 0) {
            $collection = mysqli_fetch_assoc($res);
            $collection_username = $collection['username'];
            $collection_date = substr($collection['collection_date'], 0, 10);
        }
        ?>

        <div class="collection-header-container">
            <div class="border-right">
                <!-- Back URL from https://stackoverflow.com/questions/2548566/go-back-to-previous-page -->
                <div class="back-button-container">
                    <div class="back-arrow">
                        <?php echo "<a href=\"javascript:history.go(-1)\">"; ?><img class="collection-icon"
                            src="./imgs/arrow-left.svg"></a>
                    </div>
                    <?php echo "<a href=\"javascript:history.go(-1)\">"; ?>
                    <h6>back</h6></a>
                </div>
            </div>

            <div class="collection-title-container border-right">
                <h2><?php echo $name; ?></h>
            </div>

            <div class="collection-createdby-container">
                <h3>Created by <?php echo $collection_username; ?> on <?php echo $collection_date; ?></h3>
            </div>
            
            <?php
            // Display edit/delete buttons only if logged in
            if (isset($_SESSION['username'])) {
                echo "<div class=\"edit-delete-container border-left\">";
                if ($name != "Owned" && $name != "Wishlist" && $name != "Favourites") {
                    // Displays delete button only for collections that are not Owned/Wishlist/Favourites
                    echo "<a id=\"delete\" class= \"collection\" data-url=\"" . url_for('BoardGameSite/deletecollection.php' . "?collectionid=" . $_GET['collectionid'] . "&username=" . $collection_username) . "\"><img class=\"collection-delete-img\" src=\"./imgs/delete.svg\"></a>";
                }
                echo "<a class=\"edit-button\" href=\"edit-collection.php?name=" . urlencode($name) . "&collectionid=" . urlencode($collectionid) . "\">Edit</a>";
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
            if (mysqli_num_rows($res) == 0) {
                echo "<h4>No games in this collection.</h4>";
            } else if (mysqli_num_rows($res) != 0) {
                while ($row = mysqli_fetch_assoc($res)) {
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
                    echo "<a class=\"collection-gallery-text\"href=\"" . url_for('BoardGameSite/viewboardgame.php?gameid=') . $gameid . "\">" . $game['names'] . "</a>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="JS/delete-confirmation.js"></script>
</body>

</html>