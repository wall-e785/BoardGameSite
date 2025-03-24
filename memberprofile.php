<!DOCTYPE html>
<html lang="en">

<body>
    <?php
        require('header.php');
        require_once('private/initialize.php');
    ?>
    <div class="body">
    
    <div class="flex row">
        <div class="border-right" id="username">
            <div class="padding">
                <!-- add user profile image?? -->
                <?php  echo "<h2>" . $_SESSION['username'] . "</h2>"; ?>
            </div>
        </div>
        <div class="flex wrap" id="userstats">
            <div class="padding">
            <?php
                echo "<p>Owned: </p>";
                echo "<p>Rated: </p>";
                echo "<p>Commented: </p>";
                echo "<p>Collections: </p>";
            ?>
            <!-- settings page button?? -->
            </div>
        </div>
    </div>

    <div class="flex row border-top profile-body">
        <div class="border-right">
            <div class="padding flex column">
                <h3>Recent Activity</h3>
                <div class="flex row activity"> 
                    <p>Commented on Gloomhaven<p>
                    <img src="./imgs/arrow-right.svg">
                </div>
            </div>
        </div>
        <div>
            <div class="padding flex column">
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
        </div>
    </div>
    </div>
</body>
</html>