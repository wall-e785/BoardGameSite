<?php
    require('header.php');
    
    // Initialize variables
    $GameName = null;
    $GameYear = null;
    $GameDesigner = null;
    $PlayersMin = null;
    $PlayersMax = null;
    $TimeMax = null;
    $TimeMin = null;
    $RatingMax = null;
    $RatingMin = null;
    
    $column1 = null;
    $column2 = null;
    $column3 = null;
    $column4 = null;
    $column5 = null;
    $column6 = null;
    $column7 = null;
    // Retrieve form values
    if( isset($_GET['orderNum'])) $OrderNum=$_GET['orderNum']; 
    if( isset($_GET['orderDateFrom'])) $OrderDateFrom=$_GET['orderDateFrom']; 
    if( isset($_GET['orderDateTo'])) $OrderDateTo=$_GET['orderDateTo']; 
    if( isset($_GET['column1'])) $column1=$_GET['column1']; 
    if( isset($_GET['column2'])) $column2=$_GET['column2']; 
    if( isset($_GET['column3'])) $column3=$_GET['column3']; 
    if( isset($_GET['column4'])) $column4=$_GET['column4']; 
    if( isset($_GET['column5'])) $column5=$_GET['column5']; 
    if( isset($_GET['column6'])) $column6=$_GET['column6']; 
    if( isset($_GET['column7'])) $column7=$_GET['column7']; 
    

    // Retrieve Categories and Mechanics to populate search form.
    // DB credentials 
    // include("db_connect.php");

    // // Create a connection to the database using the imported credentials
    // @$db = new mysqli($dbserver,$dbuser,$dbpass,$dbname);

    // // Check if connection is successful. If there is an error, terminate script
    // if (mysqli_connect_errno()) {
    //     die(mysqli_connect_errno());
    // }

    require_once("private/initialize.php");

    // Retrieve Categories
    // Create query string
    $query_str = "SELECT cat_name FROM Categories";
    // Execute the query 
    $res = mysqli_query($db, $query_str);
    // Check if there are any results
    if (mysqli_num_rows($res) == 0 ){
        echo "<p>Query failed and returned zero rows.</p>";
        exit();
    }
    $categories = array();
    while ($row = $res->fetch_assoc()) {
        array_push($categories, $row['cat_name']);
    }
    // initialize variables 
    for ($x = 0; $x <= sizeof($categories)-1; $x++) {
        ${"cat" . $x} = null;
    }
    // Free the result 
    $res->free_result();

    // Retrieve Mechanics
    // Create query string
    $query_str = "SELECT mec_name FROM Mechanics";
    // Execute the query 
    $res = mysqli_query($db, $query_str);
    // Check if there are any results
    if (mysqli_num_rows($res) == 0 ){
        echo "<p>Query failed and returned zero rows.</p>";
        exit();
    }
    $mechanics = array();
    while ($row = $res->fetch_assoc()) {
        array_push($mechanics, $row['mec_name']);
    }
    
    // initialize variables 
    for ($x = 0; $x <= sizeof($mechanics)-1; $x++) {
        ${"mec" . $x} = null;
    }
    // // Free the result 
    // $res->free_result();

    // // Close the database connection
    // mysqli_close($db);
       
?>

<h1>Search</h1>
<table style="border-collapse: separate; border-spacing: 20px 0px;">
    <form action="dbquery.php">
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
                    // Looping through categories we retrieved from the database to create checkboxes
                    for ($x = 0; $x <= sizeof($categories)-1; $x++) {
                        echo "<input type=\"checkbox\" id=\"cat.$x\" name=\"cat.$x\" value=\"orders.orderNumber\" ";
                        if (!empty( ${"cat" . $x} ) && ${"cat" . $x}=="orders.orderNumber") echo "checked >"; 
                        echo "<label for=\"cat.$x\">".$categories[$x]."</label>";
                    }
                ?>
            </th>
            <th align="left">
                <!-- Php code for checked status learned from lecture1 page10 file -->
                <p>Mechanics</p>
                <?php
                    // Looping through mechanics we retrieved from the database to create checkboxes
                    for ($x = 0; $x <= sizeof($mechanics)-1; $x++) {
                        echo "<input type=\"checkbox\" id=\"mec.$x\" name=\"mec.$x\" value=\"orders.orderNumber\" ";
                        if (!empty( ${"mec" . $x} ) && ${"mec" . $x}=="orders.orderNumber") echo "checked >"; 
                        echo "<label for=\"mec.$x\">".$mechanics[$x]."</label>";
                    }
                ?>
            </th>
        </tr>
        <tr>
            <th align="left"><input type="submit" value="Submit"></th>
        </tr>
    </form>
</table>

<?php
    include("search-script.php");
    
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
        // echo "<td style=\"border: 1px solid black;\">Categories</td>";
        // echo "<td style=\"border: 1px solid black;\">Mechanics</td>";
        echo "<td style=\"border: 1px solid black;\">Owned</td>";
        echo "<td style=\"border: 1px solid black;\">Designer</td>";
    echo "</tr>";
    while ($row = $res2->fetch_assoc()) {
        echo "<tr>";
        // If the column values aren't empty, then display them
        echo "<td style=\"border: 1px solid black;\" >" . $row['names'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['avg_rating'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['year'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['min_time'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['max_time'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['min_players'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['max_players'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['owned'] ."</td>";
        echo "<td style=\"border: 1px solid black;\" >" . $row['designer'] ."</td>";
       
    };
    echo "</table>";

?>
