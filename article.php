<?php
$dsn = "mysql:host=localhost:3306;dbname=forum";
$username = "root";
$password = "";

session_start();
if ($_SESSION["newsession"])
{
?>
    <hr>
    <a href="./index.php">Acceuil</a>
    <hr>
    <a href="./déconnexion.php">Déconnexion</a>

<?php
} else {
    header('location: ../login.php');
}
?>
<?php
try{
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e){
    echo $e->getMessage();
    die();
}

if(isset($_GET['articleId']) AND !empty($_GET['articleId'])) {
    $get_id = htmlspecialchars($_GET['articleId']);
    $article = $pdo->prepare('SELECT * FROM articles WHERE articleId = ?');
    $article->execute(array($get_id));
    if($article->rowCount() == 1) {
        $article = $article->fetch();
        $titre = $article['title'];
        $content = $article['description'];
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