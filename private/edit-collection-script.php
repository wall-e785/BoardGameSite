<?php
    // Initialize DB
    require_once("private/initialize.php");
    $NewCollectionName=NULL;
    //Capture new collection name if set
    if( isset($_GET['collectionName']) && !empty($_GET['collectionName'])){
        $NewCollectionName=trim($_GET['collectionName']); 
        $collectionid = (int) $_GET['collectionid']; 
        //update existing collection with new name
        $update_name_str = "UPDATE Collections SET collection_name=? WHERE collection_id=?";
        // Prepare statement
        $stmt = $db->prepare($update_name_str);
        // Bind parameters
        $stmt->bind_param("si", $NewCollectionName, $collectionid);
        // Execute the query 
        $stmt->execute();

        header("Location: collectionpage.php?name=" . urlencode($NewCollectionName) . "&collectionid=" . $collectionid);
        exit();
    } 
?>