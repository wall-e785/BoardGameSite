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

            //check if the game is already in the collection
            $check_query = $db->prepare("SELECT * FROM BelongTo WHERE collection_id = ? AND game_id = ?");
            $check_query->bind_param("ii", $selectedCollectionID, $game_id);
            $check_query->execute();
            $res = $check_query->get_result();

            if (mysqli_num_rows($res) == 0 ){
                $belongto_query = $db->prepare("INSERT INTO BelongTo (collection_id, game_id) VALUES (?, ?)");
                $belongto_query->bind_param("ii", $selectedCollectionID, $game_id);
    
                $belongto_query->execute();  
                echo "Success! Game added to collection.";
            }else{
                echo "Error: Game already in collection!";
            }            

        }else{
            // Give error that collection box must not be empty
            array_push($errorsCollection, 'Please select a collection.');
            echo "Error: Please select a collection.";
        }
    }else{
        // If not logged in, throw error that user must make an account or sign in.
        array_push($errorsCollection, 'Log in or make an account to add to collections.');
        echo "Error: Please select a collection.";
    }
?>