<?php
    $Rating = null;
    if( isset($_POST['rating']) && !empty($_POST['rating'])){
        $Rating=trim($_POST['rating']); 
    } 

    // Initialize DB
    require_once("private/initialize.php");
    
?>