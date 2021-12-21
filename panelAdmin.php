<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
session_start();
if ($_SESSION["newsession"] == "demo") {

} else {
    header('location: ../home.php');
}

if(isset($_GET['userId']) AND !empty($_GET['userId'])) {
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
<a href="home.php">Retour</a>
<ul>
    <?php while($a = $afficher_user->fetch()) { ?>
        <li>
            <a href="account.php?userId=<?= $a['id'] ?>"><?= $a['username'] ?></a> 
            <form method="POST" action=<?php echo '"dluser.php?userId=' . $a['id'] . '"' ?>>
                <input type="submit" name=<?php echo '"delete_user_' . $a['id'] . '"' ?> value="Delete user"></input> 
            </form>
        </li>
    <?php } ?>
</ul>



