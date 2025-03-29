<?php
    // Initialize DB
    require_once("private/initialize.php");
    // Find top 10 highest ranked games
    $query_str = "SELECT names,avg_rating,image_url FROM `BoardGames` ORDER BY avg_rating DESC LIMIT 10";
    
    // Execute the query 
    $res = mysqli_query($db, $query_str);
    
    // Check if there are any results
    if (mysqli_num_rows($res) == 0 ){
        echo "<p>Query failed and returned zero rows. (SEARCH PHP - CAT)</p>";
        exit();
    }
    
?>