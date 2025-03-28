<!DOCTYPE html>
<html lang="en">

<body>
<div class="body">
    <?php
        require('header.php');
        // Retrieve the game ID of the game clicked on.
        if(isset($_GET["gameid"]) && !empty($_GET["gameid"])) $gameid = $_GET["gameid"];

        // Create query string
        $query_str = "SELECT * FROM BoardGames WHERE game_id=$gameid";
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
                $avg_rating = round($row['avg_rating'], 2); // Round the rating to 2 decimals 
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
            }
        }

        // Free the result 
        $res->free_result();

        // Comment form submission 
        $errors = [];
        if(is_post_request()) {
            // Check if logged in
            if(isset($_SESSION['username'])) {
                // Check if comment box has text in it
                if(!empty($_POST['comment']) && !empty($_POST['post-comment'])){ 
                    // Save user comment
                    echo htmlspecialchars($_POST['comment']);
                    
                }else{
                    // Give error that comment box must not be empty
                    array_push($errors, 'Comment box must not be empty.');
                }
            }else{
                // If not logged in, throw error that user must make an account or sign in.
                array_push($errors, 'Log in or make an account to leave a comment.');
            }
            
        }
    ?>    
        <div class="flex row">
            <div class="border-right game-info-container flex column">
                <div class="flex row">
                    <div class="border-right">
                        <!-- Back URL from https://stackoverflow.com/questions/2548566/go-back-to-previous-page -->
                        <?php echo"<a href=\"javascript:history.go(-1)\">"; ?>
                            <div class="back-arrow centered ">
                                <img class="collection-icon" src="./imgs/arrow-left.svg">
                                <h6>back</h6>
                            </div>
                        </a>
                    </div>
                    
                    <div class="border-right game-name padding-sm">
                        <?php echo "<h2>".$game_name."</h2>"; ?>
                    </div>

                    <div class="centered padding-sm">
                        <p>Avg. Rating</p>
                        <?php echo "<h3>".$avg_rating."</h3>"; ?>
                    </div>
                </div>

                <div class="flex row space-evenly border-top padding-sm">
                <?php
                    // If min and max time are the same, only display avg time.
                    if($min_time == $max_time){
                        echo "<p>Avg. Time: ".$avg_time." min</p>";
                    }else{
                    // Else, display both min, max, and avg time
                        echo "<p>Time: ".$min_time."-".$max_time." min</p>";
                        echo "<p>Avg. Time: ".$avg_time." min</p>";
                    }
                    
                    // If min and max players are the same, only display one.
                    if($min_players==$max_players){
                        echo "<p>Players: ".$min_players."</p>";
                    }else{
                        // Else, display both min and max.
                        echo "<p>Players: ".$min_players."-".$max_players."</p>";
                    }
                ?>
                </div>

                <div class="border-top flex row game-details">
                    <div class="border-right">
                        <div class="padding-lrg">
                        <?php
                            echo "<p>Year Published: ".$year."</p>";
                            echo "<p>Designer: ".$designer."</p>";
                            echo "<p>Recommended age: ".$age."</p>";
                            echo "<p>Owned: ".$owned."</p>";
                        ?>
                        </div>
                    </div>
                    <div class="padding-sm">
                        <p>leave a rating</p>
                    </div>
                </div>
            </div>
            <div class="view-game-img-padding flex space-evenly">
                <?php echo "<img class=\"view-game-img\" src=\"$img_url\">"; ?>
            </div>
        </div> 

        <div class="border-top flex row">
            <div class="border-right catmec-container">
                <div id="categories" class="padding-lrg flex column gap1em">
                    <h3>Categories: </h3>
                    <div class="flex wrap gap1em">
                        <?php
                            // Loop through categories
                            echo "<p class=\"round-border\">category</p>";
                            echo "<p class=\"round-border\">category</p>";
                        ?>
                    </div>
                </div>

                <div id="mechanics" class="border-top padding-lrg flex column gap1em">
                    <h3>Mechanics: </h3>
                    <div class="flex wrap gap1em">
                        <?php
                            // Loop through mechanics
                            echo "<p class=\"round-border\">mechanic</p>";
                            echo "<p class=\"round-border\">mechanic</p>";
                        ?>
                    </div>
                </div>
            </div>
            <div id="comments" class="padding-lrg comment-container flex column gap1em">
                <!-- Leave a comment form -->
                <?php echo display_errors($errors); ?>
                <form action="viewboardgame.php?gameid=<?php echo $gameid?>" method="post">
                    <textarea name="comment" id="comment" placeholder="Post your Comment Here ..."></textarea><br>
                    <input type="submit" name="post-comment" value="Comment"/>
                </form>

                <h3>Comments</h3>
                <!-- box that holds all comments -->
                <div class=""> 
                    <?php
                        // Loop through comments
                        echo "<div class=\"comment-box flex column gap1em\">";
                            echo "<div class=\"flex row space-between\">";
                                echo "<p>username</p>";
                                echo "<p>datetime</p>";
                            echo "</div>";
                            echo "<p>comment desc</p>";
                        echo "</div>";
                    ?>
                </div>
            </div>
        </div>
    
</div>
</body>
</html>
