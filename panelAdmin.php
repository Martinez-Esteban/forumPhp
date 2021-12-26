<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
session_start();
$queryAdmin = $mysqli->query("SELECT admin FROM user WHERE username = '" . $_SESSION['newsession'] . "'");
$admin = $queryAdmin->fetch();
if ($admin["admin"] == 1) {

} else {
    header('location: ../home.php');
}

if(isset($_GET['userId'])) {
        $id = htmlspecialchars($_GET['userId']);
        $delete_user = $mysqli->query("DELETE FROM user WHERE id = '" . $id . "'; DELETE FROM articles WHERE userId = '" . $id . "'");
        $delete_user->execute();
        header('location: ../paneladmin.php');
        exit;
    }
// On récupère les informations de l'utilisateur connecté
$afficher_user = $mysqli->query("SELECT * FROM user");


$error = "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Administration</title>
    <link rel="icon" type="image/png" href="./css/icon.jpg" />
    <meta charset="utf-8">
    <link href='css/panelAdmin.css' rel='stylesheet'>
</head>
<body>
    <nav class="nav">
        <ul>
            <li><a href="./new.php">Publier</a>
            <?php
            if($admin['admin'] == 1) { ?>
            <li><a href="home.php">Accueil</a>
            <?php } ?>
            <li><a href="./deconnexion.php">logout</a>
            <li><a href="./account.php"><?=$_SESSION['newsession'];?></a>
        </ul>
    </nav><br><br>
    <div class="grid">
        <?php while($a = $afficher_user->fetch()) { ?>
            <div style="border-radius:  20px ;">
                <h3><a href="account.php?userId=<?= $a['id'] ?>"><?= $a['username'] ?></a></h3> 
                <form method="POST" action=<?php echo '"dluser.php?userId=' . $a['id'] . '"' ?>>
                <img src="<?= $a['pp'] ?>" height="20px" width="20px" margin-top="20px"><br>
                <input type="submit" class="btn_primary" name=<?php echo '"delete_user_' . $a['id'] . '"' ?> value="Delete user"></input>
                <h2><?= $a['creationDate'] ?></h2>
                </form>
            </div>
        <?php } ?>
    </div>
</body>