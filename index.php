<!DOCTYPE html>
<html lang="en">
<body>
    <?php
        require('header.php');
        include("./private/index-script.php");
    ?>
    <div class="body">

        <?php
        // Check if session exists 
            if(!isset($_SESSION['username'])){
                // not logged in, display seciton to sign up
                echo "<div class=\"index-header-no-user\">";
                    echo "<div class=\"border-right\">";
                        echo "<div class=\"index-title\">";
                            echo "<img class=\"playtested-icon\" src=\"./imgs/playtested.svg\">";
                            echo "<div>";
                                echo "<h1>Playtested.</h1>";
                                echo "<h3>By real people, like you. </h3>";
                            echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class=\"index-header-signup\">";
                        echo "<h3>Join the community</h3>";
                        echo "<p>You must be logged in to leave comments and make collections of your favourite games.</p>";
                    echo "</div>";
                echo "</div>";
            }else{
                // user is logged in, so just display the title
                echo "<div class=\"index-title index-header-signedin\">";
                    echo "<img class=\"playtested-icon\" src=\"./imgs/playtested.svg\">";
                    echo "<div>";
                        echo "<h1>Playtested.</h1>";
                        echo "<h3>By real people, like you. </h3>";
                    echo "</div>";
                echo "</div>";
            }
        ?>
        
        <div id="top-ranked">
            <h2>Top Ranked Games</h2>
            <div class="">
                <p>See a list of all games in order of highest rank</p>
                <img src="./imgs/arrow-right.svg">
            </div>
            <div class="index-img-scroll-container">
                <?php
                    while ($row = $res->fetch_assoc()) {
                        echo "<div class=\"index-gallery-item\">";
                            echo "<img class=\"index-gallery-img\" src=\"".$row['image_url']."\">";
                            echo "<div class=\"index-gallery-text\">";
                                echo "<h3>".round($row['avg_rating'], 2)."</h3>";
                                echo "<p>".$row['names']."</p>";
                            echo "</div>";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
        <div id="two-player">
            <h2>Best Two Player Games</h2>
            <div class="index-img-scroll-container">
                <?php
                    while ($row = $res2->fetch_assoc()) {
                        echo "<div class=\"index-gallery-item\">";
                            echo "<img class=\"index-gallery-img\" src=\"".$row['image_url']."\">";
                            echo "<div class=\"index-gallery-text\">";
                                echo "<h3>".round($row['avg_rating'], 2)."</h3>";
                                echo "<p>".$row['names']."</p>";
                            echo "</div>";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
