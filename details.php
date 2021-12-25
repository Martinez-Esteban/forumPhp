<?php
$dsn = "mysql:host=localhost:3306;dbname=forum";
$username = "root";
$password = "";

session_start();
if ($_SESSION["newsession"]) {

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
        $query = $pdo->prepare("SELECT username, pp FROM user WHERE id = '". $uid . "'");
        $query->execute();
        $user_name = $query->fetch();
    } else {
        header('location: ./home.php');
        die('Cet article n\'existe plus.');
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
    <link rel="icon" type="image/png" href="./css/icon.jpg" />
    <link href='css/details.css' rel='stylesheet'>
</head>
<body>
    <nav class="nav">
        <ul>
            <li><a href="./home.php">Acceuil</a>
            <?php
            if($_SESSION['newsession'] == 'demo') { ?>
            <li><a href="panelAdmin.php">Admin</a>
            <?php } ?>
            <li><a href="./deconnexion.php">logout</a>
            <li><a href="./account.php"><?=$_SESSION['newsession'];?></a>
        </ul>
    </nav>
    <div class="wrapper">
        <div class="blog_post">
            <div class="img_pod">
                <img src="<?php echo $user_name['pp'] ?>" height="50px" width="50px">
            </div>
            <div class="container_copy">
                <h3><?= $a['date'] ?></h3>
                <h1><?= $a['title'] ?></h1>
                <p><?= $a['description'] ?></p>
                <a href=<?php echo '"account.php?userId=' . $uid . '"' ?>><b><?= $user_name['username'] ?></b></a>
            </div> <br><br>
            <?php 
                if($_SESSION['newsession'] == $user_name['username'] || $_SESSION['newsession'] == 'demo') { ?>
                    <form method="POST" action=<?php echo '"dlpost.php?articleId=' . $a['articleId'] . '"' ?>>
                        <input type="submit" class="btn_primary" name=<?php echo '"delete_post_' . $a['articleId'] . '"' ?> value="Supprimer l'article">
                    </form>
                    <br><br>
                    <form method="POST" action=<?php echo '"edit.php?title=' . $a['title'] . '&content=' . $a['description'] . '&uid=' . $a['userId'] . '&articleId=' . $a['articleId'] . '"' ?>>
                        <input type="submit" class="btn_primary" name="edit" value="Modifier l'article">
                    </form>
                <?php } ?>
        </div>
    </div>
    <p><i><?= $a['date'] ?></i></p> - <a href=<?php echo '"account.php?userId=' . $uid . '"' ?>><b><?= $user_name['username'] ?></b></a>
    <br>
   
</body>
</html>