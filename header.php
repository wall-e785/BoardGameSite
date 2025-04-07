<html>
<head>
    <!-- This basic header structure was adapted from class Lec2 demos -->
    <title>IAT 459 Board Game Site</title>
    <link rel="stylesheet" href="./stylesheets/reset.css">
    <link rel="stylesheet" href="./stylesheets/main.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<header class="header">
    <nav class="" >
        <ul class="flex navbar"> <!-- navbar -->
            <?php
            require_once('private/initialize.php');
            $searchpage = url_for('BoardGameSite/search.php');
            $signinpage = url_for('BoardGameSite/signin.php');
            $signoutpage = url_for('BoardGameSite/signout.php');
            $profilepage = url_for('BoardGameSite/memberprofile.php');
            $index = url_for('BoardGameSite/index.php');
            echo "<li class=\"playtested\"><a class=\"flex row\" href =" . $index . "> <img src=\"./imgs/playtested.svg\"> Playtested.</a></li>";
            echo "<li class=\"border-left\"><a href =" . $searchpage . ">Search</a></li>";

            
            
            // if there is a current user session, display profile and sign out
            if(isset($_SESSION['username'])) {
                echo "<li class=\"border-left\"><a href =" . $profilepage . "?user=" . $_SESSION['username'] .">Profile</a></li>";
                echo "<li class=\"border-left\"><a href =" . $signoutpage . ">Sign Out</a></li>";
            }else{
                // else,  display sign in
                echo "<li class=\"border-left\"><a href =" . $signinpage . ">Sign In</a></li>";
            }
            ?> 
        </ul>
    </nav>
</header>



