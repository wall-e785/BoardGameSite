<?php
    require('header.php');

    include("search-script.php");

?>
<div class="body">
<h2>Search</h2>
<table style="border-collapse: separate; border-spacing: 20px 0px;">
    <form action="search.php">
        <tr>
            <th align="left">
                <label class="labelAbove" for="gameName">Board Game Name</label>
                <input class="labelAbove" type="text" id="gameName" name="gameName" size="20" <?php if (!empty($GameName)) echo "value=".$GameName; ?> >
                
                <label class="labelAbove" for="gameYear">Year</label>
                <input class="labelAbove" type="text" id="gameYear" name="gameYear" size="20" <?php if (!empty($GameYear)) echo "value=".$GameYear; ?> >
                
                <label class="labelAbove" for="gameDesigner">Designer</label>
                <input class="labelAbove" type="text" id="gameDesigner" name="gameDesigner" size="20" <?php if (!empty($GameDesigner)) echo "value=".$GameDesigner; ?> >
            </th>
            <th align="left">
                <p>Number of Players</p>
                <label for="playersMin">min: </label>
                <input type="text" id="playersMin" name="playersMin" size="3" <?php if (!empty($PlayersMin)) echo "value=".$PlayersMin; ?> >
                <label for="playersMax"> max: </label>
                <input type="text" id="playersMax" name="playersMax" size="3" <?php if (!empty($PlayersMax)) echo "value=".$PlayersMax; ?> >
                
                <p>Time</p>
                <label for="timeMin">min: </label>
                <input type="text" id="timeMin" name="timeMin" size="3" <?php if (!empty($TimeMin)) echo "value=".$TimeMin; ?> >
                <label for="timeMax"> max: </label>
                <input type="text" id="timeMax" name="timeMax" size="3" <?php if (!empty($TimeMax)) echo "value=".$TimeMax; ?> >

                <p>Average Rating</p>
                <label for="ratingMin">min: </label>
                <input type="text" id="ratingMin" name="ratingMin" size="3" <?php if (!empty($RatingMinm)) echo "value=".$RatingMin; ?> >
                <label for="ratingMax"> max: </label>
                <input type="text" id="ratingMax" name="ratingMax" size="3" <?php if (!empty($RatingMax)) echo "value=".$RatingMax; ?> >
            </th>
            <th align="left">
                <!-- Php code for checked status learned from lecture1 page10 file -->
                <p>Categories</p>
                <?php
                    // // Looping through categories we retrieved from the database to create checkboxes
                    // for ($x = 0; $x <= sizeof($categories)-1; $x++) {
                    //     echo "<input type=\"checkbox\" id=\"cat.$x\" name=\"cat.$x\" value=\"orders.orderNumber\" ";
                    //     if (!empty( ${"cat" . $x} ) && ${"cat" . $x}=="orders.orderNumber") echo "checked >"; 
                    //     echo "<label for=\"cat.$x\">".$categories[$x]."</label>";
                    // }
                ?>
                <label for="category1">Category 1</label>
                <select name="category1" id="category1">
                <option value="">   </option>
                <?php
                    // Looping through categories we retrieved from the database to create a dropdown
                    for ($x = 0; $x <= sizeof($categories)-1; $x++) {            
                        // Adapted from ChatGPT
                        $selected = ($Category1 == $categories[$x]) ? 'selected' : ''; // Compare actual category name
                        echo "<option value=\"$categories[$x]\" $selected>".$categories[$x]."</option>";
                    }
                ?>
                </select> 

                <label for="category2">Category 2</label>
                <select name="category2" id="category2">
                <option value="">   </option>
                <?php
                    // Looping through categories we retrieved from the database to create a dropdown
                    for ($x = 0; $x <= sizeof($categories)-1; $x++) {            
                        // Adapted from ChatGPT
                        $selected = ($Category2 == $categories[$x]) ? 'selected' : ''; // Compare actual category name
                        echo "<option value=\"$categories[$x]\" $selected>".$categories[$x]."</option>";
                    }
                ?>
                </select> 

                <label for="category3">Category 3</label>
                <select name="category3" id="category3">
                <option value="">   </option>
                <?php
                    // Looping through categories we retrieved from the database to create a dropdown
                    for ($x = 0; $x <= sizeof($categories)-1; $x++) {            
                        // Adapted from ChatGPT
                        $selected = ($Category3 == $categories[$x]) ? 'selected' : ''; // Compare actual category name
                        echo "<option value=\"$categories[$x]\" $selected>".$categories[$x]."</option>";
                    }
                ?>
                </select> 
            </th>
            <th align="left">
                <!-- Php code for checked status learned from lecture1 page10 file -->
                <p>Mechanics</p>
                <label for="mechanic1">Mechanic 1</label>
                <select name="mechanic1" id="mechanic1">
                <option value="">   </option>
                <?php
                    // Looping through categories we retrieved from the database to create a dropdown
                    for ($x = 0; $x <= sizeof($mechanics)-1; $x++) {            
                        // Adapted from ChatGPT
                        $selected = ($Mechanic1 == $mechanics[$x]) ? 'selected' : ''; // Compare actual category name
                        echo "<option value=\"$mechanics[$x]\" $selected>".$mechanics[$x]."</option>";
                    }
                ?>
                </select> 

                <label for="mechanic2">Mechanic 2</label>
                <select name="mechanic2" id="mechanic2">
                <option value="">   </option>
                <?php
                    // Looping through categories we retrieved from the database to create a dropdown
                    for ($x = 0; $x <= sizeof($mechanics)-1; $x++) {            
                        // Adapted from ChatGPT
                        $selected = ($Mechanic2 == $mechanics[$x]) ? 'selected' : ''; // Compare actual category name
                        echo "<option value=\"$mechanics[$x]\" $selected>".$mechanics[$x]."</option>";
                    }
                ?>
                </select> 

                <label for="mechanic3">Mechanic 3</label>
                <select name="mechanic3" id="mechanic3">
                <option value="">   </option>
                <?php
                    // Looping through categories we retrieved from the database to create a dropdown
                    for ($x = 0; $x <= sizeof($mechanics)-1; $x++) {            
                        // Adapted from ChatGPT
                        $selected = ($Mechanic3 == $mechanics[$x]) ? 'selected' : ''; // Compare actual category name
                        echo "<option value=\"$mechanics[$x]\" $selected>".$mechanics[$x]."</option>";
                    }
                ?>
                </select> 
            </th>
        </tr>
        <tr>
            <th align="left"><input type="submit" value="Submit"></th>
        </tr>
    </form>
</table>

<?php
    // Displaying query string for debugging purposes 
    echo "<p>".$query_str."</p>"; // Prints query string
    
    //Pagination code ---------------------------------------------
    if(!isset($_GET['page-nr'])){
        $page = 1;
    }else{
        $page = $_GET['page-nr'];
    }

    echo "<p>Showing ".$page." of ". $pages ." pages</p>";
    
    
    echo "<div class=\"pagination\">";
        echo "<a href=\"?page-nr=1\">First</a>";
       
        if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1 ){
            echo "<a href=\"?page-nr=". $_GET['page-nr']-1 ."\">Previous</a>";
        }else{
            echo "<a>Previous</a>";
        }
        echo "<div class=\"page-numbers\">";
            
            if($page < $pages-5){
                for($counter = $page; $counter <= $page+4; $counter ++ ){
                    echo "<a href=\"?page-nr=".$counter."\">$counter</a>"; 
                }
            }else{
                for($counter = $pages-5; $counter <= $pages; $counter ++ ){
                    echo "<a href=\"?page-nr=".$counter."\">$counter</a>"; 
                }
            }
        echo "</div>";

        if(!isset($_GET['page-nr'])){
            echo "<a href=\"?page-nr=2\">Next</a>";
        }else{
            if($_GET['page-nr'] >= $pages){
                echo "<a>Next</a>";
            }else{ 
                echo "<a href=\"?page-nr=". $_GET['page-nr']+1 ."\">Next</a>";
            }
        }
        echo "<a href=\"?page-nr=". $pages ."\">Last</a>";
    echo "</div>";

    // Display Search results ---------------------------------------------
    // Loop through the results and display them in a table
    echo "<table style=\"border: 1px solid black;\" >";
    echo "<tr>";
        echo "<td style=\"border: 1px solid black;\">Name</td>";
        echo "<td style=\"border: 1px solid black;\">Rating</td>";
        echo "<td style=\"border: 1px solid black;\">Year</td>";
        echo "<td style=\"border: 1px solid black;\">Min Time</td>";
        echo "<td style=\"border: 1px solid black;\">Max Time</td>";
        echo "<td style=\"border: 1px solid black;\">Min Players</td>";
        echo "<td style=\"border: 1px solid black;\">Max Players</td>";
        echo "<td style=\"border: 1px solid black;\">Categories</td>";
        echo "<td style=\"border: 1px solid black;\">Mechanics</td>";
        echo "<td style=\"border: 1px solid black;\">Owned</td>";
        echo "<td style=\"border: 1px solid black;\">Designer</td>";
    echo "</tr>";
    while ($row = $res2->fetch_assoc()) {
        echo "<tr>";
        // If the column values aren't empty, then display them
        $boardgamepage = url_for('BoardGameSite/viewboardgame.php');
        echo "<td style=\"border: 1px solid black;\" ><a href=\"".$boardgamepage."?gameid=".$row['game_id']."\">" . $row['names'] ."</a></td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['avg_rating'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['year'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['min_time'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['max_time'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['min_players'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['max_players'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['Categories'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['Mechanics'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['owned'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['designer'] ."</td>";
       
    };
    echo "</table>";
    
?>
</div>