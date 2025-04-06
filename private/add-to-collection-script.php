<?php

    //used by add-to-collection.js to insert/update ratings through ajax

    require_once('initialize.php');

    $errorsCollection = [];
    // Check if logged in
    if(isset($_SESSION['username'])) {
        // Check if add-to-collection select has been set
        if(!empty($_POST['collection_id'])){
            //Retrieve string value of the name of the collection they want to add to
            $selectedCollectionID = $_POST['collection_id']; 
            $game_id = $_POST['gameid'];

            $belongto_query = $db->prepare("INSERT INTO BelongTo (collection_id, game_id) VALUES (?, ?)");
            $belongto_query->bind_param("ii", $selectedCollectionID, $game_id);

            $belongto_query->execute();  

        }else{
            // Give error that collection box must not be empty
            array_push($errorsCollection, 'Please select a collection.');
        }
    }else{
        // If not logged in, throw error that user must make an account or sign in.
        array_push($errorsCollection, 'Log in or make an account to add to collections.');
    }
?>