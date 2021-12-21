<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
session_start();
if ($_SESSION["newsession"]) {

} else {
    header('location: ../login.php');
}

if(isset($_GET['userId']) AND !empty($_GET['userId'])) {
	$id = htmlspecialchars($_GET['userId']);
	$afficher_profil = $mysqli->query("SELECT * FROM user WHERE id = '" . $id . "'");
	$afficher_profil->execute();
} else {
	// On récupère les informations de l'utilisateur connecté
	$afficher_profil = $mysqli->query("SELECT * FROM user WHERE username = '" . $_SESSION["newsession"] . "'");
}
	$a = $afficher_profil->fetch();
	
	$error = "";

	// Change password function
	if(isset($_POST['confirmButton'])) {
		global $a;
		global $mysqli;
		$pwdtest = password_hash($_POST['oldpwd'], PASSWORD_BCRYPT);
		if(password_verify($_POST['oldpwd'], $a['password']) && $_POST['newpwd'] === $_POST['confirmpwd']) {
			$query = "UPDATE user SET password = '" . password_hash($_POST['newpwd'], PASSWORD_BCRYPT) . "' WHERE username = '" . $_SESSION['newsession'] . "'";
			$update = $mysqli->prepare($query);
			$update->execute();
			$error = "Mot de passe modifié avec succès !";
		} elseif (!password_verify($_POST['oldpwd'], $a['password'])) {
			$error = "Mauvais mot de passe.";
		} else {
			$error = "Les mots de passes ne correspondent pas.";
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
		<a href="./home.php">retour</a>
		<a href="./deconnexion.php">Deconnexion</a>
		<h2>Votre profil :</h2>
		<div>Quelques informations sur vous : </div>
    	<ul>
			<li>Nom d'utilisateur : <b><?= $a['username'];?></b></li>
            <li>Votre mail est : <b><?php echo $a['email'] ?></b></li>
		</ul>
		<h3>Changer de mot de passe :</h3>
		<form method="POST">
			<input type="password" name="oldpwd" placeholder="Ancien mot de passe" required /><br>
			<input type="password" name="newpwd" placeholder="Nouveau mot de passe" required /><br>
			<input type="password" name="confirmpwd" placeholder="Confirmer nouveau mot de passe" required /><br>
			<input type="submit" name="confirmButton" value="Valider">
		</form>
		<?= $error ?>
		<ul>
		<?php
		$postsQuery = $mysqli->query("SELECT title, description, date FROM articles WHERE userId = '" . $a['id'] . "' ORDER BY date DESC");
		while($post = $postsQuery->fetch()) { ?>
			<li><b><?= $post['title']; ?></b><br><?= $post['description']; ?><br><i><?= $post['date']; ?></i></li>
			<?php } ?>
		</ul>
	</body>
</html>