<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require('header.php');
        require_once('private/initialize.php');
    ?>
    <div>
        <div id="username">
            <?php
                echo "<h2>" . $_SESSION['username'] . "</h2>";
            ?>
        </div>
        <div id="userstats">
            <?php
                echo "<p>Owned: </p>";
                echo "<p>Rated: </p>";
                echo "<p>Commented: </p>";
                echo "<p>Collections: </p>";
            ?>
        </div>
    <div>

    <div class="flex row border-top profile-body">
        <div class="flex column border-right">
            <h3>Recent Activity</h3>
            <div class="flex row activity"> 
                <p>Commented on Gloomhaven<p>
                <img src="./imgs/arrow-right.svg">
            </div>
        </div>
        <div>
            <h3>Collections</h3>
            <div class="flex wrap">
                <div class="collection-preview">
                    <div class="collection-img">
                        <img class="collection-icon" src="./imgs/bookmark-filled.svg">
                    </div>
                    <h4>Owned<h4>
                </div>
                <div class="collection-preview">
                    <div class="collection-img">
                        <img class="collection-icon" src="./imgs/star-filled.svg">
                    </div>
                    <h4>Wishlist<h4>
                </div>
                <div class="collection-preview">
                    <div class="collection-img">
                        <img class="collection-icon" src="./imgs/heart-filled.svg">
                    </div>
                    <h4>Favourites<h4>
                </div>
            </div>
        </div>
    <div>
    
</body>
</html>