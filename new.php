<?php
session_start();
if ($_SESSION["newsession"]) {

} else {
    header('location: ../login.php');
}

$dsn = "mysql:host=localhost:3306;dbname=forum";
$username = "root";
$password = "";

try{
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e){
    echo $e->getMessage();
    die();
}

if(isset($_POST['article_titre'], $_POST['article_contenu'])) {
    if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'])) {
        $id = $pdo->query("SELECT id FROM user WHERE username = '" . $_SESSION['newsession'] . "'");
        $result = $id->fetch();

        $article_titre = htmlspecialchars($_POST['article_titre']);
        $article_contenu = htmlspecialchars($_POST['article_contenu']);

        $query = "INSERT INTO articles (title, description, date, userId) VALUES (:title, :desc, NOW(), :uid)";
        
        $datas = [
            'title' => $article_titre,
            'desc' => $article_contenu,
            'uid' => $result['id'],
        ];

        $ins = $pdo->prepare($query);
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
    <meta charset="utf-8">
    <link href='css/new.css' rel='stylesheet'>
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
            <li><img src="<?= $pp['pp'] ?>" height="40px" width="40px" margin-top="20px">
        </ul>
    </nav>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST">
        <input type="text" name="article_titre" placeholder="Titre de l'article" autofocus required/><br />
        <textarea name="article_contenu" placeholder="Contenu de l'article" style="width: 400px; height: 150px; color: black; resize:none;" required></textarea><br />
        <input type="submit" value="Publier l'article" />
        <?php if(isset($message)) { echo $message; } ?>
    </form>
</body>
</html>