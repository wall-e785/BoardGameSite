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

    if( isset($_GET['gameName']) && !empty($_GET['gameName'])){
        $GameName=trim($_GET['gameName']); 
    } 
    if( isset($_GET['gameYear']) && !empty($_GET['gameYear'])){ 
        $GameYear=trim($_GET['gameYear']); 
    }
    if( isset($_GET['gameDesigner']) && !empty($_GET['gameDesigner'])) {
        $GameDesigner=trim($_GET['gameDesigner']);
    }
    if( isset($_GET['playersMin']) && !empty($_GET['playersMin'])){
        $PlayersMin=$_GET['playersMin']; 
    } 
    if( isset($_GET['playersMax']) && !empty($_GET['playersMax'])) {
        $PlayersMax=$_GET['playersMax'];
    }
    if( isset($_GET['timeMin']) && !empty($_GET['timeMin'])){
        $TimeMin=$_GET['timeMin']; 
    } 
    if( isset($_GET['timeMax']) && !empty($_GET['timeMax'])){
        $TimeMax=$_GET['timeMax']; 
    } 
    if( isset($_GET['ratingMin']) && !empty($_GET['ratingMin'])){ 
        $RatingMin=$_GET['ratingMin']; 
    }
    if( isset($_GET['ratingMax']) && !empty($_GET['ratingMax'])){
        $RatingMax=$_GET['ratingMax']; 
    } 
    if( isset($_GET['category1']) && !empty($_GET['category1'])){ 
        $Category1=$_GET['category1']; 
    }
    if( isset($_GET['category2']) && !empty($_GET['category2'])){
        $Category2=$_GET['category2']; 
    } 
    if( isset($_GET['category3']) && !empty($_GET['category3'])){
       $Category3=$_GET['category3'];  
    } 
    if( isset($_GET['mechanic1']) && !empty($_GET['mechanic1'])){
        $Mechanic1=$_GET['mechanic1']; 
    } 
    if( isset($_GET['mechanic2']) && !empty($_GET['mechanic2'])){
        $Mechanic2=$_GET['mechanic2']; 
    } 
    if( isset($_GET['mechanic3']) && !empty($_GET['mechanic3'])){
        $Mechanic3=$_GET['mechanic3'];
    } 
    
    // Initialize DB
    require_once("private/initialize.php");

    // Retrieving all of the Mechanics and Categories  -----------------------------------

    // Retrieve Categories for the drop-downs
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

    // Retrieve Mechanics for the drop-downs
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

    //referenced group concat from: https://www.geeksforgeeks.org/mysql-group_concat-function/
    //first select everything from BoardGames, then using two nested queries, associated and group the
    //categories/mechanics with the same game_id into a single string
    //join the nested queries onto the main BoardGames table so each game_id has one row
    $query_str = "SELECT BoardGames.*, groupedCategories.Categories, groupedMechanics.Mechanics
    FROM BoardGames 
    LEFT JOIN (SELECT HasCategory.game_id, GROUP_CONCAT(Categories.cat_name SEPARATOR ', ') AS Categories
           FROM HasCategory
           INNER JOIN Categories ON HasCategory.cat_id  = Categories.cat_id
           GROUP BY HasCategory.game_id) groupedCategories ON groupedCategories.game_id = BoardGames.game_id
    LEFT JOIN 	(SELECT HasMechanic.game_id, GROUP_CONCAT(Mechanics.mec_name SEPARATOR ', ') AS Mechanics
           FROM HasMechanic
           INNER JOIN Mechanics ON HasMechanic.mec_id  = Mechanics.mec_id
           GROUP BY HasMechanic.game_id) groupedMechanics ON groupedMechanics.game_id = BoardGames.game_id";


    $conditions = []; // Array to store individual conditions
    $param_types = ""; // Store type definitions for bind_param (s = string, i = integer, d = double)
    $param_values = []; // Store values to bind

    // The following code for handling categories and mechanics was adapted from ChatGPT
    // Handle categories (user can select up to 3)
    $selectedCategories = array_filter([$Category1, $Category2, $Category3]); // Remove empty values
    if (!empty($selectedCategories)) {
        $placeholderCats = implode(',', array_fill(0, count($selectedCategories), '?')); // Creates "?, ?, ?" dynamically
        $conditions[] = "BoardGames.game_id IN (
            SELECT HasCategory.game_id
            FROM HasCategory
            INNER JOIN Categories ON HasCategory.cat_id = Categories.cat_id
            WHERE Categories.cat_name IN ($placeholderCats)
            GROUP BY HasCategory.game_id
            HAVING COUNT(DISTINCT HasCategory.cat_id) = ?
        )";
    
        // Add category names and the required count to parameters
        $param_types .= str_repeat("s", count($selectedCategories)) . "i";
        $param_values = array_merge($param_values, $selectedCategories, [count($selectedCategories)]);
    }
    // Handle categories (user can select up to 3)
    $selectedMechanics = array_filter([$Mechanic1, $Mechanic2, $Mechanic3]); // Remove empty values
    if (!empty($selectedMechanics)) {
        $placeholderMecs = implode(',', array_fill(0, count($selectedMechanics), '?')); // Creates "?, ?, ?" dynamically
        $conditions[] = "BoardGames.game_id IN (
            SELECT HasMechanic.game_id
            FROM HasMechanic
            INNER JOIN Mechanics ON HasMechanic.mec_id = Mechanics.mec_id
            WHERE Mechanics.mec_name IN ($placeholderMecs)
            GROUP BY HasMechanic.game_id
            HAVING COUNT(DISTINCT HasMechanic.mec_id) = ?
        )";
    
        // Add category names and the required count to parameters
        $param_types .= str_repeat("s", count($selectedMechanics)) . "i";
        $param_values = array_merge($param_values, $selectedMechanics, [count($selectedMechanics)]);
    }

    if (!empty($GameName)) {
        // make sure game name is text
        $conditions[] = "BoardGames.names LIKE ?";
        $param_types .= "s";  // "s" for string
        $param_values[] = "$GameName%"; // Add wildcard for LIKE
    }

    if (!empty($GameYear) ){
        if(ctype_digit($GameYear) && strlen($GameYear) === 4) {
            $conditions[] = "BoardGames.year = ?";
            $param_types .= "i";  // "i" for integer
            $param_values[] = (int)$GameYear;
        }else{
            // error: year must be a 4 digit number
        }
    }

    if (!empty($GameDesigner)){
        $conditions[] = "BoardGames.designer LIKE ?";
        $param_types .= "s";  // "s" for string
        $param_values[] = "$GameDesigner%";
    }

    if (!empty($PlayersMin)){
        if(ctype_digit($PlayersMin)){
            $conditions[] = "BoardGames.min_players = ?";
            $param_types .= "i";  // "i" for integer
            $param_values[] = (int)$PlayersMin;
        }else{
            // error: must be number
        }
    }
    if (!empty($PlayersMax)){
        if(ctype_digit($PlayersMax)){
            $conditions[] = "BoardGames.max_players = ?";
            $param_types .= "i";  // "i" for integer
            $param_values[] = (int)$PlayersMax;
        }else{
            // error: must be number
        }
    }
    if (!empty($TimeMin)){
        if(ctype_digit($TimeMin)){
            $conditions[] = "BoardGames.min_time = ?";
            $param_types .= "i";  // "i" for integer
            $param_values[] = (int)$TimeMin;
        }else{
            // error: must be number
        }
    }
    if (!empty($TimeMax)){
        if(ctype_digit($TimeMax)){
            $conditions[] = "BoardGames.max_time = ?";
            $param_types .= "i";  // "i" for integer
            $param_values[] = (int)$TimeMax;
        }else{
            // error: must be number
        }
    }
    if (!empty($RatingMin)){
        if(is_numeric($RatingMin)){
            $conditions[] = "BoardGames.avg_rating >= ?";
            $param_types .= "d";  // "d" for double (float)
            $param_values[] = (float)$RatingMin;
        }else{
            // error: must be number
        }
    }
    if (!empty($RatingMax)){
        if(is_numeric($RatingMax)){
            $conditions[] = "BoardGames.avg_rating <= ?";
            $param_types .= "d";  // "d" for double (float)
            $param_values[] = (float)$RatingMax;
        }else{
            // error: must be number
        }
    }


    // If there are conditions, join them with "AND" and append to query
    if (!empty($conditions)) {
        $query_str .= " WHERE " . implode(" AND ", $conditions);
    }

    // ending query string
    $query_str = $query_str . " 
    GROUP BY BoardGames.game_id
    LIMIT $start, $rows_per_page";

    // Prepare statement
    $stmt = $db->prepare($query_str);

    // Bind parameters dynamically
    if (!empty($param_values)) {
        $stmt->bind_param($param_types, ...$param_values);
    }


    

    // Execute the query 
    // $res2 = mysqli_query($db, $query_str);
    $stmt->execute();
    $res2 = $stmt->get_result();

    // Check if there are any results
    if (mysqli_num_rows($res2) == 0 ){
        echo "<p>Query failed and returned zero rows. (SEARCH-SCRIPT PHP)</p>";
        // exit();
    }

      // Free the result 
    //  $res2->free_result();

     // Close the database connection
    //  mysqli_close($db2);

?>