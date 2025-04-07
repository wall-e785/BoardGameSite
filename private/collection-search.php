<?php

    require_once('initialize.php');

    //search for names that are like the entered value
    $query = $db->prepare("SELECT game_id, names, image_url FROM BoardGames WHERE names LIKE ?");
    $query->bind_param("s", $input);

    //referneced wildcards from: https://www.w3schools.com/sql/sql_wildcards.asp
    $input = "%" . $_POST["input"] . "%";
    $query->execute();
    $res = $query->get_result();

    //referenced this to encode the sql results into JSON
    //https://stackoverflow.com/questions/383631/json-encode-mysql-results
    //add the rows into an array to pass to back to the JS file using a JSON object
    $rows = array();
    while($row = mysqli_fetch_assoc($res)){
        $rows[] = $row;
    }

    $res->free_result();

    //referenced this to properly return JSON object to ajax
    //https://stackoverflow.com/questions/7064391/php-returning-json-to-jquery-ajax-call
    header('Content-Type: application/json');
    echo json_encode($rows);
?>