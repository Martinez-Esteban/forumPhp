<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
    if(isset($_GET['articleId'])) {
        $id = htmlspecialchars($_GET['articleId']);
        $delete_post = $mysqli->prepare("DELETE FROM articles WHERE articleId = " . $id);
        $delete_post->execute();
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Something went wrong ...";
    }
?>