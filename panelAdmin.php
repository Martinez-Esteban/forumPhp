<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
session_start();
if ($_SESSION["newsession"] == "Demo") {

} else {
    header('location: ../login.php');
}

// On récupère les informations de l'utilisateur connecté
$afficher_user = $mysqli->query("SELECT * FROM user");


$error = "";
?>
<ul>
    <?php while($a = $afficher_user->fetch()) { ?>
        <li>
            <a href="account.php?userId=<?= $a['id'] ?>"><?= $a['username'] ?></a> 
            <form method="POST" action="dluser.php">
                <input type="submit" name="dl_user" value=Delete user></input> 
            </form>
        </li>
    <?php } ?>
</ul>



