<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
session_start();
if ($_SESSION["newsession"]) {
    
} else {
    header('location: ../login.php');
}
$user = $mysqli->prepare("SELECT pp FROM user WHERE username = '" . $_SESSION['newsession'] . "'");
$user->execute();
$queryAdmin = $mysqli->prepare("SELECT admin FROM user WHERE username = '" . $_SESSION['newsession'] . "'");
$queryAdmin->execute();
$admin = $queryAdmin->fetch();
$pp = $user->fetch();
$articles = $mysqli->prepare('SELECT * FROM articles ORDER BY date DESC');
$articles->execute();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Acceuil</title>
    <link rel="icon" type="image/png" href="./css/icon.jpg" />
    <meta charset="utf-8">
    <link href='css/home.css' rel='stylesheet'>
</head>
<body>
    <nav class="nav">
        <ul>
            <li><a href="./new.php">Publier</a>
            <?php
            if($admin['admin'] == 1) { ?>
            <li><a href="panelAdmin.php">Admin</a>
            <?php } ?>
            <li><a href="./deconnexion.php">logout</a>
            <li><a href="./account.php"><?=$_SESSION['newsession'];?></a>
            <li><img src="<?= $pp['pp'] ?>" height="40px" width="40px" margin-top="20px">
        </ul>
    </nav>
    <div class="search">
        <form action="search.php" method="GET">
            <input id="search" name="search" type="text" placeholder="Recherchez un post !" class="search-bar">
            <!-- <button class="search-btn" type="submit" value="Search"></button> --> 
        </form><br><br>
    </div>
    <div class="grid">
        
        <?php while($a = $articles->fetch()) { ?>
            <div style="border-radius:  20px ;">
                <li><a href="details.php?articleId=<?= $a['articleId'] ?>"><?= $a['title'] ?> - <?= $a['date'] ?></a>
                    <h4 maxlength="20"><?= $a['description'] ?></h4>
                </li>
            </div>
        <?php } ?>
        
    </div>
</body>
</html>