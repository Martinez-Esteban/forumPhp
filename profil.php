<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
session_start();
if ($_SESSION["newsession"]) {

} else {
    header('location: ../login.php');
}
?>

<?php
  // On récupère les informations de l'utilisateur connecté
  $afficher_profil = $mysqli->query("SELECT * FROM user WHERE username =" . $_SESSION["newsession"]);
  $a = $afficher_profil->fetch()
?>

<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Mon profil</title>
	<head>
	<body>
		<h2>Voici le profil de <?= $_SESSION["newsession"];?></h2>
		<div>Quelques informations sur vous : </div>
    	<ul>
            <li>Votre id est : <?php $a['id']?></li>
            <li>Votre mail est :<?php $a['email'] ?></li>
		</ul>
	</body>
</html>