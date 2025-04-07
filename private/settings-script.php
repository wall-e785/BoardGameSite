<?php
    require_once('initialize.php');
    
    // Check if logged in
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        // Check if user pressed delete account button
        if(isset($_POST['delete_account'])){ 
            // Delete user
            $stmt = $db->prepare("DELETE FROM Users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $stmt->close();
            session_destroy();
            
            redirect_to(url_for('BoardGameSite/index.php'));
        }
    }
?>