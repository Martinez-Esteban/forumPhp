<?php
session_start();
if ($_SESSION["newsession"]) {
?>

<?php
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
</head>
<body>
    <form method="POST">
        <input type="text" name="article_titre" placeholder="Titre de l'article" required/><br />
        <textarea name="article_contenu" placeholder="Contenu de l'article" required></textarea><br />
        <input type="submit" value="Publier l'article" />
    </form>
    <br />
    <?php if(isset($message)) { echo $message; } ?>
    <br>
    <a href="./home.php">Retour</a>
</body>
</html>