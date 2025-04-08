<!DOCTYPE html>
<html lang="en">

<body>
<div class="body">
    <?php
        require('header.php');
        
        // Retrieve the game ID of the game clicked on.
        if(isset($_GET["gameid"]) && !empty($_GET["gameid"])) $gameid = $_GET["gameid"];
        
        //current URL
        $currentURL = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Create query string to load board game info
        $query_str = "SELECT BoardGames.*, groupedCategories.Categories, groupedMechanics.Mechanics
        FROM BoardGames 
        LEFT JOIN (SELECT HasCategory.game_id, GROUP_CONCAT(Categories.cat_name SEPARATOR ', ') AS Categories
               FROM HasCategory
               INNER JOIN Categories ON HasCategory.cat_id  = Categories.cat_id
               GROUP BY HasCategory.game_id) groupedCategories ON groupedCategories.game_id = BoardGames.game_id
        LEFT JOIN 	(SELECT HasMechanic.game_id, GROUP_CONCAT(Mechanics.mec_name SEPARATOR ', ') AS Mechanics
               FROM HasMechanic
               INNER JOIN Mechanics ON HasMechanic.mec_id  = Mechanics.mec_id
               GROUP BY HasMechanic.game_id) groupedMechanics ON groupedMechanics.game_id = BoardGames.game_id
        WHERE BoardGames.game_id=$gameid";

        // Execute the query 
        $res = mysqli_query($db, $query_str);
        // Check if there are any results
        if (mysqli_num_rows($res) == 0 ){
            echo "<p>Query failed and returned zero rows. (SEARCH PHP - CAT)</p>";
            exit();
        }
        // Save variables
        if(mysqli_num_rows($res) != 0) {
            while($row= mysqli_fetch_assoc($res)) {
                $game_name = $row['names'];
                $existing_avg = round($row['avg_rating'], 2); // Round the rating to 2 decimals 
                $num_votes = $row['num_votes'];
                $designer = $row['designer'];
                $img_url = $row['image_url'];
                $age = $row['age'];
                $year = $row['year'];
                $owned =  $row['owned'];
                $min_players = $row['min_players'];
                $max_players = $row['max_players'];
                $avg_time = $row['avg_time'];
                $min_time = $row['min_time'];
                $max_time = $row['max_time'];
                $mechanics_str = $row['Mechanics'];
                $mechanics_array = explode(",", $mechanics_str);
                $categories_str = $row['Categories'];
                $categories_array = explode(",", $categories_str);
            }
        }
        // Free the result 
        $res->free_result();

        //calculate avg rating-------------
        $avg_rating_query_str = "SELECT game_id, rating_num FROM `Ratings` WHERE game_id=$gameid";
        // Execute the query 
        $res = mysqli_query($db, $avg_rating_query_str);
        if(mysqli_num_rows($res) != 0) {
            $new_count = mysqli_num_rows($res);
            $new_sum = 0;
            while($row= mysqli_fetch_assoc($res)) {
                $new_sum += floatval($row['rating_num']);
            }
            $avg_rating = round(($existing_avg * $num_votes + $new_sum) / ($num_votes + $new_count), 2);
        }else{
            // there are no new ratings for this game, so display the existing avg.
            $avg_rating = $existing_avg;
        }
        // Free the result 
        $res->free_result();

    ?>    
        <div class="flex-row">
            <div class="game-info-container border-right">
                <div class="flex-row">
                    <div class="border-right">
                        <!-- Back URL from https://stackoverflow.com/questions/2548566/go-back-to-previous-page -->
                        <div class="back-button-container">
                            <div class="back-arrow">
                                <?php echo"<a href=\"javascript:history.go(-1)\">"; ?><img class="collection-icon" src="./imgs/arrow-left.svg"></a>
                            </div>
                            <?php echo"<a href=\"javascript:history.go(-1)\">"; ?><h6>back</h6></a>
                        </div>
                    </div>
                    
                    <div class="game-name border-right">
                        <?php echo "<h2>".$game_name."</h2>"; ?>
                    </div>

                    <div class="avg-rating">
                        <p>Avg. Rating</p>
                        <?php echo "<h3>".$avg_rating."</h3>"; ?>
                    </div>
                </div>

                <div class="game-info-row border-top ">
                <?php
                    // If min and max time are the same, only display avg time.
                    if($min_time == $max_time){
                        echo "<h3>Avg. Time: ".$avg_time." min</h3>";
                    }else{
                    // Else, display both min, max, and avg time
                        echo "<h3>Time: ".$min_time."-".$max_time." min</h3>";
                        echo "<h3>Avg. Time: ".$avg_time." min</h3>";
                    }
                    
                    // If min and max players are the same, only display one.
                    if($min_players==$max_players){
                        echo "<h3>Players: ".$min_players."</h3>";
                    }else{
                        // Else, display both min and max.
                        echo "<h3>Players: ".$min_players."-".$max_players."</h3>";
                    }
                ?>
                </div>

                <div class="border-top flex-row details-rating-container">
                    <div class="game-details-container border-right">
                        <div class="game-details">
                        <?php
                            echo "<p>Year Published: ".$year."</p>";
                            echo "<p>Designer: ".$designer."</p>";
                            echo "<p>Recommended age: ".$age."</p>";
                            echo "<p>Owned: ".$owned."</p>";
                        ?>
                        </div>
                    </div>
                    <div class="leave-rating-container">
                        <!---------- Leave ratings ----------->
                        <?php
                        if(!empty($_SESSION['username'])){
                            echo "<form class=\"rating-collection-form\">";
                                echo "<label for=\"rating\">Leave a Rating:</label>";
                                echo "<select name=\"rating\" id=\"rating\">";
                                    echo "<option value=\"\">   </option>"; //First option blank
                                        // Looping to create numbers

                                        $rating_query_str = "SELECT rating_num, username, game_id FROM `Ratings` WHERE username='" . $_SESSION['username'] . "' AND game_id = '" . $_GET['gameid'] . "'";
                                        $res = mysqli_query($db, $rating_query_str);

                                        $select = -1;
                                        
                                        if (mysqli_num_rows($res) > 0){
                                            // Looping through rating that user has
                                            while ($row = $res->fetch_assoc()) {
                                                $select = $row['rating_num'];
                                            }
                                        }    

                                        for ($x = 1; $x <11; $x++) {    
                                            $selected = ($Rating == $x) ? 'selected' : ''; // Displays user's rating if previously submitted     
                                            if($x == $select){
                                                echo "<option selected value=\"$x\" $selected>".$x."</option>";
                                            }else{
                                                echo "<option value=\"$x\" $selected>".$x."</option>";
                                            }
                                        }
                                echo "</select>";
                                echo "<button type=\"button\" id=\"submit-rating\" data-game-id=\"" . $gameid . "\">Submit Rating</button>";
                            echo "</form>";

                            //Add to a collection
                            echo "<form class=\"rating-collection-form\">";
                                echo "<label for=\"add-to-collection\">Add to a collection:</label>";
                                echo "<select name=\"add-to-collection\" id=\"add-to-collection\">";
                                    echo "<option value=\"\">   </option>"; //First option blank
                                    if(isset($_SESSION['username'])){ // Only if the user is logged in
                                        // Check what collections user has
                                        $collection_query_str = "SELECT collection_name, collection_id FROM `Collections` WHERE username='" . $_SESSION['username'] . "'";
                                        $res = mysqli_query($db, $collection_query_str);
                                        
                                        if (mysqli_num_rows($res) > 0){
                                                // Looping through collections that user has
                                            while ($row = $res->fetch_assoc()) {
                                                echo "<option value=\"".$row['collection_id']."\">".$row['collection_name']."</option>";
                                            }
                                        }    
                                        // Free the result 
                                        $res->free_result();
                                    } 
                                echo "</select>";
                                echo "<button type=\"button\" id=\"add-collection\" data-game-id=\"" . $gameid . "\">Add</button>";
                            echo "</form>";
                        }else{
                            echo "<a href=\"" . url_for('BoardGameSite/signin.php') . "\"><p>Log In to Rate Games/Make Collections</p></a>"; 
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="view-game-img-container">
                <?php echo "<img class=\"view-game-img\" src=\"$img_url\">"; ?>
            </div>
        </div> 

        <div class="border-top flex row">
            <div class="border-right catmec-container">
                <div id="categories" class="padding-lrg flex column gap1em">
                    <h3>Categories: </h3>
                    <div class="categories-container">
                        <?php
                            // Loop through categories
                            foreach ($categories_array as $category){
                                echo "<p class=\"\">".$category."</p>";
                            }
                        ?>
                    </div>
                </div>

                <div id="mechanics" class="border-top padding-lrg flex column gap1em">
                    <h3>Mechanics: </h3>
                    <div class="categories-container">
                        <?php
                            // Loop through mechanics
                            foreach ($mechanics_array as $mechanic){
                                echo "<p class=\"\">".$mechanic."</p>";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div id="comments" class="padding-lrg comment-container flex column gap1em">
                <!-- Leave a comment form -->
                <form>
                    <?php
                        if(!empty($_SESSION['username'])){
                            echo "<textarea class=\"comment-form\" name=\"comment\" id=\"comment\" placeholder=\"Post your Comment Here ...\"></textarea><br>";
                            echo "<button type=\"button\" id=\"post-comment\" data-game-id=\"" . $gameid . "\">Comment</button>"; 
                        }else{
                            echo "<a href=\"" . url_for('BoardGameSite/signin.php') . "\"><p>Log In to Post Comments</p></a>"; 
                        }      
                     ?>
                </form>

                <h3>Comments</h3>
                <!-- box that holds all comments -->
                <div class="comments-container"> 
                    <?php
                        // Loop through comments
                        $comments_query = "SELECT * 
                                            FROM Comments
                                            WHERE game_id =". $_GET['gameid'];

                        // Execute the query 
                        $res = mysqli_query($db, $comments_query);
                        // Check if there are any results
                        if (mysqli_num_rows($res) == 0 ){
                            echo "<p>No Comments yet!</p>";
                            //exit();
                        }
                        // Save variables
                        if(mysqli_num_rows($res) != 0) {
                            while($row= mysqli_fetch_assoc($res)) {
                                //custom data referenced from: https://www.w3schools.com/tags/att_data-.asp
                                echo "<div class=\"comment-box flex column gap1em\" id=\"" . $row["comment_id"] . "\" data-comment-id=\"". $row["comment_id"]."\">";
                                    echo "<div class=\"comment-header\">";
                                        echo "<a href=\"" . url_for('BoardGameSite/memberprofile.php?user=' . $row["username"]) ."\"><p>". $row["username"] ."</p></a>";
                                        echo "<div class=\"comment-date\">";
                                            echo "<p>". $row["comment_date"] ."</p>";
                                            //only show delete if the comment is by the logged in user
                                            if(!empty($_SESSION["username"])){
                                                if($row["username"] == $_SESSION["username"]){
                                                    echo "<a class=\"comment\" data-url=\"" . url_for('BoardGameSite/deletecomment.php?commentid=') . $row["comment_id"] . "&gameid=". $row["game_id"] . "\">";
                                                        echo "<img class=\"comment-delete\" src=\"./imgs/delete.svg\">";
                                                    echo "</a>";
                                                }   
                                            }
                                        echo "</div>";
                                    echo "</div>";
                                    echo "<p class=\"comment-content\" id=\"comment-".$row["comment_id"]."\" data-comment-id=\"". $row["comment_id"] ."\">". $row["comment_desc"] ."</p>";
                                    //only show edit if the comment is by the logged in user
                                    if(!empty($_SESSION["username"])){
                                        if($row["username"] == $_SESSION["username"]){
                                            echo "<button type=\"button\" class=\"edit-button\" data-comment-id=\"".$row["comment_id"]."\">Edit</button>";
                                        }   
                                    }
                                echo "</div>";
                            }
                        }

                        $res->free_result();
                    ?>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="JS/edit-comments.js"></script>
<script src="JS/submit-rating.js"></script>
<script src="JS/add-to-collection.js"></script>
<script src="JS/add-comment.js"></script>
<script src="JS/delete-confirmation.js"></script>
</body>
</html>
