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
    <!-- icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=auto_read_play" />
</head>
<body>
<header class="header">
    <nav class="" >
        <ul class="flex navbar"> <!-- navbar -->
            <?php
            require_once('private/initialize.php');
            $searchpage = url_for('BoardGameSite/search.php');
            $signinpage = url_for('BoardGameSite/signin.php');
            $index = url_for('BoardGameSite/index.php');
            $profilepage = null; 
            echo "<li class=\"playtested\"><a class=\"flex row\" href =" . $index . "> <span style=\"font-size: 30px\" class=\"material-symbols-rounded\">auto_read_play</span> Playtested.</a></li>";
            echo "<li class=\"border-left\"><a href =" . $searchpage . ">Search</a></li>";
            echo "<li class=\"border-left\"><a href =" . $profilepage . ">Profile</a></li>";
            echo "<li class=\"border-left\"><a href =" . $signinpage . ">Sign In</a></li>";
            
            ?> 
        </ul>
    </nav>
</header>



