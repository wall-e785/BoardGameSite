<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once('private/initialize.php');
        $signinpage = url_for('BoardGameSite/signout.php');
        echo "<a href =" . $signinpage . ">Sign Out</a>";
    ?>
</body>
</html>