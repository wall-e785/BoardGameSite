<!--used to create a new collection-->
<!DOCTYPE html>
<html lang="en">

<body>
    <div class="body">
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
        <div class="collection-header-container">
            <div class="border-right">
                <!-- Back URL from https://stackoverflow.com/questions/2548566/go-back-to-previous-page -->
                <div class="back-button-container">
                    <div class="back-arrow">
                        <?php echo"<a href=\"javascript:history.go(-1)\">"; ?><img class="collection-icon" src="./imgs/arrow-left.svg"></a>
                    </div>
                    <?php echo"<a href=\"javascript:history.go(-1)\">"; ?><h6>back</h6></a>
                </div>
            </div>
            <div class="collection-title-container border-right">
                <h2>New Collection</h2>
            </div>
            <div class="make-collection-save-container">
                <h3>Save collection:</h3>
                <button type="submit" id = "save" value="Save">Save</button>
            </div>
        </div>

        <div class="collection-createdby-container border-bottom">
            <h3>1. Name your Collection </h3>
            <input type="text" name="name" class="collection-name" placeholder="How would you describe this collection?"/>
        </div>

        <div class="make-collection-search-container">
            
            <h3>2. Select Games</h3>
            <div class="selected-games">
                <?php
                    // Display only if there is a game selected
                    
                        echo "<p>Selected:</p>";
                        echo "<div class=\"make-collection-wrap\" id=\"selected-games\">";
                            //games here 
                        echo "</div>";
                    
                ?>
            </div>
            <div class="make-collection-search">
                <input type="text" name="search" class="" id="search-input" placeholder="Search for games by name here..."/>
            </div>

            <div class="make-collection-wrap" id="selector-area">
                <?php
                // $boardgames = "SELECT game_id, names, image_url 
                //                 FROM BoardGames";

                // // Execute the query 
                // $res = mysqli_query($db, $boardgames);
                // // Check if there are any results
                // if (mysqli_num_rows($res) == 0 ){
                //     echo "<h4>Error: Could not retrieve games, try again later.</h4>";
                // }else if(mysqli_num_rows($res) != 0) {
                //     while($row= mysqli_fetch_assoc($res)){
                //         echo "<label class=\"game-card\">";
                //             echo "<input type=\"checkbox\" name=\"game\" value=\"" . $row['game_id'] . "\">";
                //             echo "<img src=\"" . $row['image_url'] . "\">";
                //             echo "<p class=\"game-card-title\">".$row['names']."</p>";
                //         echo "</label>";
                //     }
                // }
                ?>
            </div>
        </div>
        </form>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="JS/collection-search.js"></script>
</html>

