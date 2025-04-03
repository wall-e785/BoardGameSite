<?php
    require('header.php');

    include("./private/search-script.php");

?>
<div class="body">
    <div id="SearchForm">
        <h2>Search</h2>
        <form action="search.php">
            <div class="search-form-container">
                <div class="search-column">
                    <label class="labelAbove" for="gameName">Board Game Name</label>
                    <input class="labelAbove" type="text" id="gameName" name="gameName"<?php if (!empty($GameName)) echo "value=".$GameName; ?> >
                    
                    <label class="labelAbove" for="gameYear">Year</label>
                    <input class="labelAbove" type="text" id="gameYear" name="gameYear"<?php if (!empty($GameYear)) echo "value=".$GameYear; ?> >
                    
                    <label class="labelAbove" for="gameDesigner">Designer</label>
                    <input class="labelAbove" type="text" id="gameDesigner" name="gameDesigner"<?php if (!empty($GameDesigner)) echo "value=".$GameDesigner; ?> >
                </div>
                <div class="search-column">
                    
                    <p>Number of Players</p>
                    <div class="search-form-numfield">
                        <label for="playersMin">min: </label>
                        <input type="text" id="playersMin" name="playersMin"<?php if (!empty($PlayersMin)) echo "value=".$PlayersMin; ?> >
                        <label for="playersMax"> max: </label>
                        <input type="text" id="playersMax" name="playersMax"<?php if (!empty($PlayersMax)) echo "value=".$PlayersMax; ?> >
                    </div>

                    <p>Time</p>
                    <div class="search-form-numfield">
                        <label for="timeMin">min: </label>
                        <input type="text" id="timeMin" name="timeMin"<?php if (!empty($TimeMin)) echo "value=".$TimeMin; ?> >
                        <label for="timeMax"> max: </label>
                        <input type="text" id="timeMax" name="timeMax"<?php if (!empty($TimeMax)) echo "value=".$TimeMax; ?> >
                    </div>

                    <p>Average Rating</p>
                    <div class="search-form-numfield">
                        <label for="ratingMin">min: </label>
                        <input type="text" id="ratingMin" name="ratingMin"<?php if (!empty($RatingMinm)) echo "value=".$RatingMin; ?> >
                        <label for="ratingMax"> max: </label>
                        <input type="text" id="ratingMax" name="ratingMax"<?php if (!empty($RatingMax)) echo "value=".$RatingMax; ?> >
                    </div>
                </div>
                <div class="search-column">
                    <p>Categories</p>
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
                </div>
                <div class="search-column">
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
                </div>
            </div>
            <input type="submit" value="Submit">
        </form>
    <?php
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
    
    ?>   
    </div>



<?php
    // Display Search results ---------------------------------------------
    // Loop through the results and display them in a table
    echo "<table class=\"gamestable\">";
    echo "<tr>";
        echo "<td class=\"table-header\">Name</td>";
        echo "<td class=\"table-header\">Rating</td>";
        echo "<td class=\"table-header\">Year</td>";
        echo "<td class=\"table-header\">Min Time</td>";
        echo "<td class=\"table-header\">Max Time</td>";
        echo "<td class=\"table-header\">Min Players</td>";
        echo "<td class=\"table-header\">Max Players</td>";
        echo "<td class=\"table-header\">Categories</td>";
        echo "<td class=\"table-header\">Mechanics</td>";
        echo "<td class=\"table-header\">Owned</td>";
        echo "<td class=\"table-header\">Designer</td>";
    echo "</tr>";
    while ($row = $res2->fetch_assoc()) {
        echo "<tr>";
        // If the column values aren't empty, then display them
        $boardgamepage = url_for('BoardGameSite/viewboardgame.php');
        echo "<td><a href=\"".$boardgamepage."?gameid=".$row['game_id']."\">" . $row['names'] ."</a></td>";
        echo "<td>" . $row['avg_rating'] ."</td>";
        echo "<td>" . $row['year'] ."</td>";
        echo "<td>" . $row['min_time'] ."</td>";
        echo "<td>" . $row['max_time'] ."</td>";
        echo "<td>" . $row['min_players'] ."</td>";
        echo "<td>" . $row['max_players'] ."</td>";
        echo "<td>" . $row['Categories'] ."</td>";
        echo "<td>" . $row['Mechanics'] ."</td>";
        echo "<td>" . $row['owned'] ."</td>";
        echo "<td>" . $row['designer'] ."</td>";
       
    };
    echo "</table>";
    
?>
</div>