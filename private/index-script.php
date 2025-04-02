<?php
    // Initialize DB
    require_once("private/initialize.php");
    // Find top 10 highest ranked games
    $top_games_query = "SELECT names,avg_rating,image_url,game_id FROM `BoardGames` ORDER BY avg_rating DESC LIMIT 10";
    
    // Execute the query 
    $res = mysqli_query($db, $top_games_query);
    
    // Check if there are any results
    if (mysqli_num_rows($res) == 0 ){
        echo "<p>Query failed and returned zero rows. (INDEX PHP - TOP GAMES)</p>";
        exit();
    }
    
    $two_player_query = "SELECT names,avg_rating,image_url,game_id,max_players FROM `BoardGames` WHERE max_players=2 ORDER BY avg_rating DESC LIMIT 10";
    $res2 = mysqli_query($db, $two_player_query);
    // Check if there are any results
    if (mysqli_num_rows($res2) == 0 ){
        echo "<p>Query failed and returned zero rows. (INDEX PHP - TWO PLAYER)</p>";
        exit();
    }

    $horror_query = "SELECT BoardGames.*, groupedCategories.Categories
        FROM BoardGames
        LEFT JOIN (
            SELECT HasCategory.game_id, GROUP_CONCAT(Categories.cat_name SEPARATOR ', ') AS Categories
            FROM HasCategory
            INNER JOIN Categories ON HasCategory.cat_id = Categories.cat_id
            GROUP BY HasCategory.game_id
        ) groupedCategories ON groupedCategories.game_id = BoardGames.game_id
        WHERE EXISTS (
            SELECT 1
            FROM HasCategory
            WHERE HasCategory.game_id = BoardGames.game_id
            AND HasCategory.cat_id = 19
        )
        ORDER BY avg_rating DESC
        LIMIT 10";
    $res3 = mysqli_query($db, $horror_query);
    // Check if there are any results
    if (mysqli_num_rows($res3) == 0 ){
        echo "<p>Query failed and returned zero rows. (INDEX PHP - TWO PLAYER)</p>";
        exit();
    }
?>