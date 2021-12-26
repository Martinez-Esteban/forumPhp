<?php 
session_start();
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
$queryAdmin = $mysqli->query("SELECT admin FROM user WHERE username = '" . $_SESSION['newsession'] . "'");
$admin = $queryAdmin->fetch();
if ($_SESSION["newsession"]) {

} else {
    header('location: ../login.php');
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Article(s) recherché(s)</title>
    <link rel="icon" type="image/png" href="./css/icon.jpg" />
    <meta charset="utf-8">
    <link href='css/new.css' rel='stylesheet'>
</head>
<body>

    <nav class="nav">
        <ul>
            <li><a href="./home.php">Accueil</a>
            <li><a href="./new.php">Publier</a>
            <?php
                if($admin['admin'] == 1) { ?>
                <li><a href="panelAdmin.php">Admin</a>
            <?php } ?>
            <li><a href="./deconnexion.php">logout</a>
            <li><a href="./account.php"><?=$_SESSION['newsession'];?></a>
        </ul>
    </nav>
</body>

<?php

if(isset($_GET['search'])){
    echo("Voici les résultats pour : " . $_GET['search']);
    $delete_user = $mysqli->prepare("SELECT * FROM articles WHERE title LIKE '%".$_GET['search']."%'");
    $delete_user ->execute();
    echo("<div class='grid'>");
    echo "<ul>";
    while ($row = $delete_user->fetch()) {
        echo "<div><li><b><a href=./details.php?articleId=".$row['articleId'].">".$row['title']."</a></b><br>".$row['description']."<br><i>".$row['date']."</i></li>";  
    }
    echo "</ul>";  
} else {
    echo "something went wrong";
}
?>

