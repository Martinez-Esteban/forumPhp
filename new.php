<?php
session_start();
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
$queryAdmin = $mysqli->query("SELECT admin FROM user WHERE username = '" . $_SESSION['newsession'] . "'");
$admin = $queryAdmin->fetch();

if ($_SESSION["newsession"]) {

} else {
    header('location: ../login.php');
}


if(isset($_POST['article_titre'], $_POST['article_contenu'])) {
    if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'])) {
        $id = $mysqli->query("SELECT id, pp FROM user WHERE username = '" . $_SESSION['newsession'] . "'");
        $result = $id->fetch();

        $article_titre = htmlspecialchars($_POST['article_titre']);
        $article_contenu = htmlspecialchars($_POST['article_contenu']);

        $query = "INSERT INTO articles (title, description, date, userId) VALUES (:title, :desc, NOW(), :uid)";
        
        $datas = [
            'title' => $article_titre,
            'desc' => $article_contenu,
            'uid' => $result['id'],
        ];

        $ins = $mysqli->prepare($query);
        $ins->execute($datas);

        $message = 'Votre article a été posté';
    
    } else {
        $message = 'Veuillez remplir tous les champs';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nouvel Article</title>
    <link rel="icon" type="image/png" href="./css/icon.jpg" />
    <meta charset="utf-8">
    <link href='css/new.css' rel='stylesheet'>
</head>
<body>
    <nav class="nav">
        <ul>
            <li><a href="./home.php">Acceuil</a>
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
        <h3 style ="color:white;"> Création du post !</h3> 
        <input type="text" name="article_titre" placeholder="Titre de l'article" autofocus required/><br />
        <textarea name="article_contenu" placeholder="Contenu de l'article" style="width: 400px; height: 150px; color: black; resize:none; border-radius: 10px;" required></textarea><br />
        <input type="submit" value="Publier l'article" />
        <?php if(isset($message)) { echo $message; } ?>
    </form>
</body>
</html>