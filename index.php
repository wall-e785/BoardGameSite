<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
      // require('header.php');

        require_once('private/initialize.php');
         echo "<a href=\"search.php\">To Search Page</a>";
        $signinpage = url_for('BoardGameSite/signin.php');
        echo "<a href =" . $signinpage . ">Sign In</a>";
    ?>
</body>
</html>
