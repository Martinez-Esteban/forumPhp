<?php

session_start();
if ($_SESSION["newsession"]) {

} else {
    header('location: ../login.php');
}

try{
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
} catch (PDOException $e){
    echo $e->getMessage();
    die();
}

if(isset($_GET['title']) AND isset($_GET['content']) AND isset($_GET['uid']) AND isset($_GET['articleId'])) {
    $afficher_profil = $pdo->prepare("SELECT username FROM user WHERE id = '" . $_GET['uid'] . "'");
	$afficher_profil->execute();
    $a = $afficher_profil->fetch();
    if($_SESSION['newsession'] == $a['username'] || $_SESSION['newsession'] == 'demo') {
        $article = $pdo->prepare("SELECT * FROM articles WHERE articleId = '" . $_GET['articleId'] . "'");
        $article->execute();
        $result = $article->fetch();
    } else {
        header('location: ' . $_SERVER['HTTP_REFERER']);
    }
}

if(isset($_POST['article_titre'], $_POST['article_contenu'])) {
    if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'])) {
        $update = $pdo->prepare("UPDATE articles SET title = '" . $_POST['article_titre'] . "', description = '" . $_POST['article_contenu'] . "' WHERE articleId = '" . $_GET['articleId'] . "'");
        $update->execute();
        header('location: ../details.php?articleId=' . $_GET['articleId']);
    }
}
?>

<form method="POST">
    <input type="text" name="article_titre" value=<?php echo $result['title'] ?> required/><br />
    <textarea name="article_contenu" value=<?php echo $result['description'] ?> required></textarea><br />
    <input type="submit" value="Modifier l'article" />
</form>