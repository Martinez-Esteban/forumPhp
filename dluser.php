<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
    if(isset($_GET['userId']) AND !empty($_GET['userId'])) {
        $id = htmlspecialchars($_GET['userId']);
        $delete_user = $mysqli->query("DELETE FROM user WHERE id = '" . $id . "'; DELETE FROM articles WHERE userId = '" . $id . "'");
        $delete_user->execute();
        header('location: ../paneladmin.php');
        exit;
    }
    else {
    echo "dhur";
    }
?>