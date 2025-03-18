<?php
    // // DB credentials 
    // include("db_connect.php");

    // // Create a connection to the database using the imported credentials
    // @$db2 = new mysqli($dbserver,$dbuser,$dbpass,$dbname);

    // // Check if connection is successful. If there is an error, terminate script
    // if (mysqli_connect_errno()) {
    //     die(mysqli_connect_errno());
    // }

    require_once("private/initialize.php");

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

    // Create query string
    $query_str = "SELECT * FROM BoardGames  LIMIT $start, $rows_per_page";

    // Execute the query 
    $res2 = mysqli_query($db, $query_str);

    // Check if there are any results
    if (mysqli_num_rows($res2) == 0 ){
        echo "<p>Query failed and returned zero rows.</p>";
        exit();
    }

      // Free the result 
    //  $res2->free_result();

     // Close the database connection
    //  mysqli_close($db2);

?>