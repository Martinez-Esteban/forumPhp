<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");

if(isset($_POST['article_titre'], $_POST['article_contenu'])) {
    if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'])) {

        $article_titre = htmlspecialchars($_POST['article_titre']);
        $article_contenu = htmlspecialchars($_POST['article_contenu']);
        $ins = $mysqli->prepare('INSERT INTO articles (title, description, date) VALUES (?, ?, NOW())');
        $ins->execute(array($article_titre, $article_contenu));
        $message = 'Votre article a été posté';
    
    } else {
        $message = 'Veuillez remplir tous les champs';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>NewArticle</title>
    <meta charset="utf-8">
</head>
<body>
    <form method="POST">
        <input type="text" name="article_titre" placeholder="Titre de l'article" /><br />
        <textarea name="article_contenu" placeholder="Contenu de l'article"></textarea><br />
        <input type="submit" value="Publier l'article" />
    </form>
    <br />
    <?php if(isset($message)) { echo $message; } ?>
</body>
</html>