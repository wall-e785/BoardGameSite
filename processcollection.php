<?php
//receives ajax post and processes the selected games to insert into a collection
require_once('private/initialize.php');

if (!empty($_POST['checked']) && !empty($_SESSION['username'])) {
    $selected = $_POST['checked'];
    $username = $_SESSION['username'];
    $name = $_POST['name'];

    if (!empty($name) && !empty($_SESSION['username'])) {
        // Save user comment
        //referenced prepared statements: https://www.w3schools.com/php/php_mysql_prepared_statements.asp
        $insert_str = $db->prepare("INSERT INTO Collections (collection_name, collection_date, username) VALUES (?, ?, ?)");
        //referenced date/time from: https://www.w3schools.com/php/php_date.asp
        $insert_str->bind_param("sss", $name, $datetime, $username);

        $name = $_POST['name'];
        $datetime = date("Y-m-d") . " " . date("H:i:s");
        $username = $_SESSION['username'];
        $insert_str->execute();

        //referenced latest row from: https://www.geeksforgeeks.org/sql-query-to-get-the-latest-record-from-the-table/
        $get_query = "SELECT collection_id
                          FROM Collections
                          ORDER BY collection_id DESC
                          LIMIT 1";

        $res = mysqli_query($db, $get_query);

        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $id = $row['collection_id'];

            $belongto_query = $db->prepare("INSERT INTO BelongTo (collection_id, game_id) VALUES (?, ?)");
            foreach ($selected as $game_id) {
                $belongto_query->bind_param("ii", $id, $game_id);
                $belongto_query->execute();
            }
        }

        echo url_for('/memberprofile.php?user=' . $_SESSION['username']);

    }
}
?>