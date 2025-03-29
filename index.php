<!DOCTYPE html>
<html lang="en">
<body>
    <?php
        require('header.php');
        include("./private/index-script.php");
    ?>
    <div class="body">
    
    
        <div class="flex row">
            <img class="playtested-icon" src="./imgs/playtested.svg">
            <div>
                <h1>Playtested.</h1>
                <h3>By real people, like you. </h3>
            </div> 
        </div>
        <div>
            <h2>Top Ranked Games</h2>
            <div class="flex row">
                <?php
                    while ($row = $res->fetch_assoc()) {
                        echo "<div>";
                            echo "<img src=\"".$row['image_url']."\">";
                            echo "<h3>".$row['avg_rating']."</h3>";
                            echo "<p>".$row['names']."</p>";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
