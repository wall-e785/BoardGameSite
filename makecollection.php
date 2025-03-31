<!--used to create a new collection-->
<!DOCTYPE html>
<html lang="en">

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="JS/selected-games.js"></script>

    <div class="body">

        <div class="flex row">
            <h2>New Collection</h2>
        </div>

    <?php


    require('header.php');
    require_once('private/initialize.php');

    $errors = [];
    $name = ''; 
    // if(is_post_request()) {
        

    //     $name = $_POST['name'];

    //     if(!empty($name) && !empty($_SESSION['username'])){
    //         // Save user comment
    //         //referenced prepared statements: https://www.w3schools.com/php/php_mysql_prepared_statements.asp
    //         $insert_str = $db -> prepare("INSERT INTO Collections (collection_name, collection_date, username) VALUES (?, ?, ?)");
    //         //referenced date/time from: https://www.w3schools.com/php/php_date.asp
    //         $insert_str->bind_param("sss", $name, $datetime, $username);
            
    //         $name = $_POST['name'];
    //         $datetime = date("Y-m-d") . " " . date("H:i:s");
    //         $username = $_SESSION['username'];
    //         $insert_str->execute();  
            
    //         redirect_to(url_for('BoardGameSite/memberprofile.php'));
    //     }else{
    //         array_push($errors, "Enter a name for this collection!");
    //     }


    //     echo display_errors($errors);
    // }

    ?>
    <form>
        <div class="flex column">
            <h3>1. Name your Collection </h3>
            Name<br />
            <input type="text" name="name" class="collection-name" value="" /><br />
            <input type="submit" id = "submit"/>

        </div>

        <div class="flex row">
            <h3>2. Select Games (Optional)</h3>
        </div>

        <div class="flex make-collection-wrap">
            <?php
            $boardgames = "SELECT game_id, names, image_url 
                            FROM BoardGames";

            // Execute the query 
            $res = mysqli_query($db, $boardgames);
            // Check if there are any results
            if (mysqli_num_rows($res) == 0 ){
                echo "<h4>Error: Could not retrieve games, try again later.</h4>";
            }else if(mysqli_num_rows($res) != 0) {
                while($row= mysqli_fetch_assoc($res)){
                    echo "<div class=\"collection-preview\">";
                        echo "<div class=\"collection-preview\">";
                            echo "<img class=\"make-collection-img\" src=\"" . $row['image_url'] . "\">";
                        echo "</div>";
                        echo "<h4>". $row['names'] . "</h4>";
                        echo "<input type=\"checkbox\" name=\"game\" class= \"game\" value=\"" . $row['game_id'] . "\">";
                    echo "</div>";
                }
            }
            ?>
        </div>
        </form>
    </div>

</body>
</html>

