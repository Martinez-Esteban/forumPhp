<?php
$dsn = "mysql:host=localhost:3306;dbname=forum";
$username = "root";
$password = "";

session_start();
if ($_SESSION["newsession"]) {
?>
    <hr>
    <a href="./home.php">retour</a>
    <hr>
<?php
} else {
    header('location: ../login.php');
}

try{
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e){
    echo $e->getMessage();
    die();
}

// On récupère l'article passé en paramètre
if(isset($_GET['articleId']) AND !empty($_GET['articleId'])) {
    $get_article_id = htmlspecialchars($_GET['articleId']);
    $article = $pdo->prepare("SELECT * FROM articles WHERE articleId = '" . $get_article_id . "'");
    $article->execute();
    if($article->rowCount() == 1) {
        $a = $article->fetch();
        $uid = $a['userId'];
        $query = $pdo->prepare("SELECT username FROM user WHERE id = '". $uid . "'");
        $query->execute();
        $user_name = $query->fetch();
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
    <h1><?= $a['title'] ?></h1>
    <p><?= $a['description'] ?></p>
    <p><i><?= $a['date'] ?></i></p> - <a href=<?php echo '"account.php?userId=' . $uid . '"' ?>><b><?= $user_name['username'] ?></b></a>
    <?php 

    if($_SESSION['newsession'] == $user_name['username'] || $_SESSION['newsession'] == 'demo') { ?>

        <form method="POST" action=<?php echo '"dlpost.php?articleId=' . $a['articleId'] . '"' ?>>
            <input type="submit" name=<?php echo '"delete_post_' . $a['articleId'] . '"' ?> value="Supprimer l'article">
        </form>
        <form method="POST" action=<?php echo '"edit.php?title=' . $a['title'] . ';content=' . $a['description'] . ';uid=' . $a['userId'] . '"' ?>>
            <input type="submit" name=<?php echo '"edit_post_' . $a['articleId'] . '"' ?> value="Modifier l'article">
        </form>

    <?php } ?>
</body>
</html>