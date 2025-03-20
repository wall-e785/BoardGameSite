<?php
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
    $Category1 = null;
    $Category2 = null;
    $Category3 = null;
    $Mechanic1 = null;
    $Mechanic2 = null;
    $Mechanic3 = null;

    $FormInputArray = [];

    // Retrieve form values
    if( isset($_GET['gameName']) && !empty($_GET['gameName'])){
        $GameName=$_GET['gameName']; 
        $FormInputArray = $GameName;
    } 
    if( isset($_GET['gameYear']) && !empty($_GET['gameYear'])){ 
        $GameYear=$_GET['gameYear']; 
        $FormInputArray = $GameYear;
    }
    if( isset($_GET['gameDesigner']) && !empty($_GET['gameDesigner'])) {
        $GameDesigner=$_GET['gameDesigner'];
        $FormInputArray = $GameDesigner;
    }
    if( isset($_GET['playersMin']) && !empty($_GET['playersMin'])){
        $PlayersMin=$_GET['playersMin']; 
        $FormInputArray = $PlayersMin;
    } 
    if( isset($_GET['playersMax']) && !empty($_GET['playersMax'])) {
        $PlayersMax=$_GET['playersMax'];
        $FormInputArray = $PlayersMax;
    }
    if( isset($_GET['timeMin']) && !empty($_GET['timeMin'])){
        $TimeMin=$_GET['timeMin']; 
        $FormInputArray = $TimeMin; 
    } 
    if( isset($_GET['timeMax']) && !empty($_GET['timeMax'])){
        $TimeMax=$_GET['timeMax']; 
        $FormInputArray = $TimeMax;
    } 
    if( isset($_GET['ratingMin']) && !empty($_GET['ratingMin'])){ 
        $RatingMin=$_GET['ratingMin']; 
        $FormInputArray = $RatingMin;
    }
    if( isset($_GET['ratingMax']) && !empty($_GET['ratingMax'])){
        $RatingMax=$_GET['ratingMax']; 
        $FormInputArray = $RatingMax;
    } 
    if( isset($_GET['category1']) && !empty($_GET['category1'])){ 
        $Category1=$_GET['category1']; 
        $FormInputArray = $Category1;
    }
    if( isset($_GET['category2']) && !empty($_GET['category2'])){
        $Category2=$_GET['category2']; 
        $FormInputArray = $Category2;
    } 
    if( isset($_GET['category3']) && !empty($_GET['category3'])){
       $Category3=$_GET['category3'];  
       $FormInputArray = $Category3;
    } 
    if( isset($_GET['mechanic1']) && !empty($_GET['mechanic1'])){
        $Mechanic1=$_GET['mechanic1']; 
        $FormInputArray = $Mechanic1;
    } 
    if( isset($_GET['mechanic2']) && !empty($_GET['mechanic2'])){
        $Mechanic2=$_GET['mechanic2']; 
        $FormInputArray = $Mechanic2;
    } 
    if( isset($_GET['mechanic3']) && !empty($_GET['mechanic3'])){
        $Mechanic3=$_GET['mechanic3'];
        $FormInputArray = $Mechanic3;
    } 
    
    // Initialize DB
    require_once("private/initialize.php");

    // Retrieving all of the Mechanics and Categories  -----------------------------------

    // Retrieve Categories
    // Create query string
    $query_str = "SELECT cat_name FROM Categories";
    // Execute the query 
    $res = mysqli_query($db, $query_str);
    // Check if there are any results
    if (mysqli_num_rows($res) == 0 ){
        echo "<p>Query failed and returned zero rows. (SEARCH PHP - CAT)</p>";
        exit();
    }
    $categories = array();
    while ($row = $res->fetch_assoc()) {
        array_push($categories, $row['cat_name']);
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
        echo "<p>Query failed and returned zero rows. (SEARCH PHP - MEC)</p>";
        exit();
    }
    $mechanics = array();
    while ($row = $res->fetch_assoc()) {
        array_push($mechanics, $row['mec_name']);
    }
    
    // Free the result 
     $res->free_result();


    // Pagination  ---------------------------------------------------------------------
    // Pagination learned from https://www.youtube.com/watch?v=3-5DpAiCHy8
    // What page to start on
    $start = 0;
    // How many rows to display on each page
    $rows_per_page = 10;

    // find total number of rows
    $records_query = "SELECT * FROM BoardGames";
    // Execute the query 
    $records = mysqli_query($db, $records_query);
    $nr_of_rows = $records->num_rows;
    $pages = ceil($nr_of_rows / $rows_per_page);

    // If the user clicks on pagination buttons we set a new starting point
    if(isset($_GET['page-nr'])){
        $page = $_GET['page-nr'] - 1; // Starts counting rows at index 0
        $start = $page * $rows_per_page;
    }

    // Search page query ------------------------------------------

    // Create query string
    $query_str = "SELECT BoardGames.*, 
    GROUP_CONCAT(Categories.cat_name SEPARATOR ', ') AS Categories, 
    GROUP_CONCAT(Mechanics.mec_name SEPARATOR ', ') AS Mechanics  FROM BoardGames 
    JOIN HasCategory ON BoardGames.game_id = HasCategory.game_id 
    JOIN Categories ON HasCategory.cat_id = Categories.cat_id 
    JOIN HasMechanic ON BoardGames.game_id = HasMechanic.game_id
    JOIN Mechanics ON HasMechanic.mec_id = Mechanics.mec_id";

    // for ($x = 0; $x <= sizeof($FormInputArray); $x++) {
    //      echo $FormInputArray[$x];
    // }
  

    // Checking what the user inputted
    if (!empty($GameName)){
        // Find names that start with whatever the user inputted, not just exact matches
        $query_str = $query_str." WHERE BoardGames.names LIKE '$GameName%'";
    }
    if(!empty($TimeMin)){
        if(ctype_digit($TimeMin)){ // If its actually an int value
            $query_str = $query_str."AND BoardGames.min_time =$TimeMin";
        }else{
            //throw an error that says to enter int values 
        }
    }

    // ending query string
    $query_str = $query_str . " 
    GROUP BY BoardGames.game_id
    LIMIT $start, $rows_per_page";

    // Execute the query 
    $res2 = mysqli_query($db, $query_str);

    // Check if there are any results
    if (mysqli_num_rows($res2) == 0 ){
        echo "<p>Query failed and returned zero rows. (SEARCH-SCRIPT PHP)</p>";
        exit();
    }

      // Free the result 
    //  $res2->free_result();

     // Close the database connection
    //  mysqli_close($db2);

?>