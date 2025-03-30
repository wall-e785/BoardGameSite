<?php
    // Initialize DB
    require_once("private/initialize.php");
    // Find top 10 highest ranked games
    $top_games_query = "SELECT names,avg_rating,image_url FROM `BoardGames` ORDER BY avg_rating DESC LIMIT 10";
    
    // Execute the query 
    $res = mysqli_query($db, $top_games_query);
    
    // Check if there are any results
    if (mysqli_num_rows($res) == 0 ){
        echo "<p>Query failed and returned zero rows. (INDEX PHP - TOP GAMES)</p>";
        exit();
    }
    
    $two_player_query = "SELECT names,avg_rating,image_url,max_players FROM `BoardGames` WHERE max_players=2 ORDER BY avg_rating DESC LIMIT 10";
    $res2 = mysqli_query($db, $two_player_query);
    // Check if there are any results
    if (mysqli_num_rows($res2) == 0 ){
        echo "<p>Query failed and returned zero rows. (INDEX PHP - TWO PLAYER)</p>";
        exit();
    }
?>