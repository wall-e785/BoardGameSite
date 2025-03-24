<!DOCTYPE html>
<html lang="en">

<body>
<div class="body">
    <?php
        require('header.php');
        $gameid = $_GET["gameid"];
        
    ?>
    <div class="flex row">
        <div class="border-right">
            <div class="flex row">
                <div class="border-right">
                    <h2>Game Name</h2>
                </div>

                <div class="centered">
                    <p>Avg. Rating</p>
                    <h3>8.99</h3>
                </div>
            </div>

            <div class="flex row space-evenly border-top">
            <?php
                echo "<p>Time: </p>";
                echo "<p>Avg. Time: </p>";
                echo "<p>Players: </p>";
            ?>
            </div>

            <div class="border-top flex row">
                <div>
                <?php

                    echo "<p>Year Published: </p>";
                    echo "<p>Designer: </p>";
                    echo "<p>Recommended age: </p>";
                    echo "<p>Owned: </p>";
                ?>
                </div>
                <div>
                    <p>leave a rating</p>
                </div>
            </div>
        </div>
        <div class="view-game-img ">
        </div>
    </div> 

    <div class="border-top flex row">
        <div class="border-right">
            <div id="categories" class="padding">
                <h3>Categories: </h3>
                <div class="flex wrap">
                    <?php
                        // Loop through categories
                        echo "<p class=\"round-border\">category</p>";
                    ?>
                </div>
            </div>

            <div id="mechanics" class="border-top padding">
                <h3>Mechanics: </h3>
                <div class="flex wrap">
                    <?php
                        // Loop through mechanics
                        echo "<p class=\"round-border\">mechanic</p>";
                    ?>
                </div>
            </div>
        </div>
        <div id="comments" class="padding">
            <h3>Comments</h3>
            <!-- box that holds all comments -->
            <div class="flex column"> 
                <?php
                    // Loop through comments
                    echo "<div class=\"comment-box flex column\">";
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
