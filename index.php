<!DOCTYPE html>
<html lang="en">

<body>
    <?php
    require('header.php');
    include("./private/index-script.php"); // Runs 3 queries to populate this page with games
    ?>
    <div class="body">

        <?php
        // Check if session exists 
        if (!isset($_SESSION['username'])) {
            // Not logged in, display seciton to sign up
            echo "<div class=\"flex row border-bottom\">";
                echo "<div class=\"index-header-no-user-container\">";
                    echo "<div class=\"flex row\">";
                        echo "<img class=\"playtested-icon\" src=\"./imgs/playtested.svg\">";
                        echo "<div>";
                            echo "<h1>Playtested.</h1>";
                            echo "<h3>By real people, like you. </h3>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                echo "<div class=\"flex column index-header-signup\">";
                    echo "<h3>Join the community</h3>";
                    echo "<p>You must be logged in to leave comments and make collections of your favourite games.</p>";
                    echo "<a href =" . $signinpage . ">";
                    echo "<div class=\"flex row signup-today-button\">";
                        echo "<h3>Sign up for free today! </h3>"; 
                        echo "<svg class=\"signup-icon\" xmlns=\"http://www.w3.org/2000/svg\" height=\"24px\" viewBox=\"0 -960 960 960\" width=\"24px\" fill=\"#000000\"><path d=\"M647-440H200q-17 0-28.5-11.5T160-480q0-17 11.5-28.5T200-520h447L451-716q-12-12-11.5-28t12.5-28q12-11 28-11.5t28 11.5l264 264q6 6 8.5 13t2.5 15q0 8-2.5 15t-8.5 13L508-188q-11 11-27.5 11T452-188q-12-12-12-28.5t12-28.5l195-195Z\"/></svg>";
                    echo "</div>";
                    echo "</a>";
                echo "</div>";
            echo "</div>";
        } else {
            // User is logged in, so just display the title
            echo "<div class=\"flex row index-header-signedin\">";
                echo "<img class=\"playtested-icon\" src=\"./imgs/playtested.svg\">";
                echo "<div>";
                    echo "<h1>Playtested.</h1>";
                    echo "<h3>By real people, like you. </h3>";
                echo "</div>";
            echo "</div>";
        }
        ?>

        <div id="top-ranked" class="index-section border-bottom">
            <h2>Top Ranked Games</h2>
            <div class="index-img-scroll-container">
                <?php
                while ($row = $res->fetch_assoc()) {
                    echo "<div class=\"index-gallery-item\">";
                    echo "<img class=\"index-gallery-img\" src=\"" . $row['image_url'] . "\">";
                    echo "<div class=\"index-gallery-text\">";
                    echo "<h3>" . round($row['avg_rating'], 2) . "</h3>";
                    echo "<a href=\"" . url_for('viewboardgame.php?gameid=') . $row['game_id'] . "\"><p>" . $row['names'] . "</p></a>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <div id="two-player" class="index-section border-bottom">
            <h2>Best Two Player Games</h2>
            <div class="index-img-scroll-container">
                <?php
                while ($row = $res2->fetch_assoc()) {
                    echo "<div class=\"index-gallery-item\">";
                    echo "<img class=\"index-gallery-img\" src=\"" . $row['image_url'] . "\">";
                    echo "<div class=\"index-gallery-text\">";
                    echo "<h3>" . round($row['avg_rating'], 2) . "</h3>";
                    echo "<a href=\"" . url_for('viewboardgame.php?gameid=') . $row['game_id'] . "\"><p>" . $row['names'] . "</p></a>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <div id="horror" class="index-section">
            <h2>Best Horror Games</h2>
            <div class="index-img-scroll-container">
                <?php
                while ($row = $res3->fetch_assoc()) {
                    echo "<div class=\"index-gallery-item\">";
                    echo "<img class=\"index-gallery-img\" src=\"" . $row['image_url'] . "\">";
                    echo "<div class=\"index-gallery-text\">";
                    echo "<h3>" . round($row['avg_rating'], 2) . "</h3>";
                    echo "<a href=\"" . url_for('viewboardgame.php?gameid=') . $row['game_id'] . "\"><p>" . $row['names'] . "</p></a>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>