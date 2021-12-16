<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");

if(isset($_GET['article_id']) AND !empty($_GET['article_id'])) {
    $get_id = htmlspecialchars($_GET['article_id']);
    $article = $mysqli->prepare('SELECT * FROM articles WHERE article_id = ?');
    $article->execute(array($get_id));
    if($article->rowCount() == 1) {
        $article = $article->fetch();
        $titre = $article['titre'];
        $content = $article['content'];
    } else {
        die('Cet article n\'existe pas');
    }
} else {
    die('Erreur');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Acceuil</title>
    <meta charset="utf-8">
</head>
<body>
    <h1><?= $titre ?></h1>
    <p><?= $content ?></p>
</body>
</html>