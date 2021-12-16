<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");

$articles = $mysqli->query('SELECT * FROM articles ORDER BY date DESC');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Acceuil</title>
    <meta charset="utf-8">
</head>
<body>
    <a href="./newArticle.php">Nouvel Article</a>
    <a href="./index.php">Acceuil</a>
    <ul>
        <?php while($a = $articles->fetch()) { ?>
        <li><a href="article.php?articleId=<?= $a['articleId'] ?>"><?= $a['title'] ?> - <?= $a['date'] ?></a></li>
        <?php } ?>
    </ul>
</body>
</html>