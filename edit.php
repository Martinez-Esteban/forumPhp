<?php
session_start();
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
$queryAdmin = $mysqli->query("SELECT admin FROM user WHERE username = '" . $_SESSION['newsession'] . "'");
$admin = $queryAdmin->fetch();

if ($_SESSION["newsession"]) {

} else {
    header('location: ../login.php');
}

if(isset($_GET['title']) AND isset($_GET['content']) AND isset($_GET['uid']) AND isset($_GET['articleId'])) {
    $afficher_profil = $mysqli->prepare("SELECT username FROM user WHERE id = '" . $_GET['uid'] . "'");
	$afficher_profil->execute();
    $a = $afficher_profil->fetch();
    if($_SESSION['newsession'] == $a['username'] || $admin['admin']== 1) {
        $article = $mysqli->prepare("SELECT * FROM articles WHERE articleId = '" . $_GET['articleId'] . "'");
        $article->execute();
        $result = $article->fetch();
    } else {
        header('location: ' . $_SERVER['HTTP_REFERER']);
    }
}

if(isset($_POST['article_titre'], $_POST['article_contenu'])) {
    if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'])) {
        $update = $mysqli->prepare("UPDATE articles SET title = '" . $_POST['article_titre'] . "', description = '" . $_POST['article_contenu'] . "' WHERE articleId = '" . $_GET['articleId'] . "'");
        $update->execute();
        header('location: ../details.php?articleId=' . $_GET['articleId']);
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Édition de post</title>
    <link rel="icon" type="image/png" href="./css/icon.jpg" />
    <meta charset="utf-8">
    <link href='css/new.css' rel='stylesheet'>
</head>
<body>
    <nav class="nav">
            <ul>
                <li><a href="./home.php">Accueil</a>
                <?php
                if($admin['admin'] == 1) { ?>
                    <li><a href="panelAdmin.php">Admin</a>
                <?php } ?>
                <li><a href="./deconnexion.php">logout</a>
                <li><a href="./account.php"><?=$_SESSION['newsession'];?></a>
            </ul>
    </nav>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST">
        <h3 style ="color:white;"> Modification du post !</h3> 
        <input type="text" name="article_titre" value="<?php echo $result['title'] ?>" required/><br />
        <textarea  name="article_contenu" style="width: 400px; height: 150px; color: black; resize:none; border-radius: 10px;" autofocus required><?php echo $result['description'] ?></textarea><br />
        <input type="submit" value="Modifier l'article" />
    </form>
</body>