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
  $afficher_profil = $mysqli->query("SELECT * FROM user WHERE username = '" . $_SESSION["newsession"] . "'");
  $a = $afficher_profil->fetch();

  function verifyPassword($mysqli) {
	global $a;
	global $mysqli;
	$pwdtest = password_hash($_POST['oldpwd'], PASSWORD_BCRYPT);
	if($pwdtest === $a['password'] && $_POST['newpwd'] === $_POST['confirmpwd']) {
		$query = "UPDATE user SET password = '" . password_hash($_POST['newpwd'], PASSWORD_BCRYPT) . "' WHERE username = '" . $_SESSION['newsession'] . "'";
		$update = $mysqli->prepare($query);
		$update->execute();
	} else {
		echo "bah non";
	}
}
?>

<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Mon profil</title>
	<head>
	<body>
		<a href="./index.php">retour</a>
		<h2>Voici le profil de <?= $_SESSION["newsession"];?></h2>
		<div>Quelques informations sur vous : </div>
    	<ul>
            <li>Votre id est : <?php echo $a['id']?></li>
            <li>Votre mail est : <?php echo $a['email'] ?></li>
		</ul>
		<form method="POST" onsubmit="<?=verifyPassword($mysqli)?>">
			<input type="password" name="oldpwd" placeholder="Ancien mot de passe" required /><br>
			<input type="password" name="newpwd" placeholder="Nouveau mot de passe" required /><br>
			<input type="password" name="confirmpdw" placeholder="Confirmer nouveau mot de passe" required /><br>
			<input type="submit" value="Valider">
		</form>
	</body>
</html>

<?php



?>