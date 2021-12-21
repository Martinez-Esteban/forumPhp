<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
session_start();
if ($_SESSION["newsession"]) {
    
} else {
    header('location: ../login.php');
}
$articles = $mysqli->query('SELECT * FROM articles ORDER BY date DESC');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Acceuil</title>
    <meta charset="utf-8">
</head>
<body>
    <ul>
        <li><a href="./account.php">Profil</a>
        <?php

        if($_SESSION["newsession"] == "demo") {
        ?>
        <li><a href="./panelAdmin.php">Administration</a>
        <?php } ?>
        <li><a href="./new.php">Nouvel Article</a>
        <li><a href="./deconnexion.php">Déconnexion</a>
    </ul>
    <h1>ARTICLES :</h1>
    <ul>
        <?php while($a = $articles->fetch()) { ?>
        <li><a href="details.php?articleId=<?= $a['articleId'] ?>"><?= $a['title'] ?> - <?= $a['date'] ?></a></li>
        <?php } ?>
    </ul>
</body>
</html>