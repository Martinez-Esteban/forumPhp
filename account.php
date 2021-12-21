<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
session_start();

// On vérifie si l'utilisateur est connecté
if ($_SESSION["newsession"]) {

} else {
    header('location: ../login.php');
}

if(isset($_GET['userId']) AND !empty($_GET['userId'])) {
	// On récupère les information de l'utilisateur passé en paramètre dans le lien
	$id = htmlspecialchars($_GET['userId']);
	$afficher_profil = $mysqli->query("SELECT * FROM user WHERE id = '" . $id . "'");
	$afficher_profil->execute();
} else {
	// On récupère les informations de l'utilisateur connecté
	$afficher_profil = $mysqli->query("SELECT * FROM user WHERE username = '" . $_SESSION["newsession"] . "'");
}
	$a = $afficher_profil->fetch();
	
	$error = "";

	// Fonction pour changer le mot de passe
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
		<title>Profil de <?php echo $a['username'] ?></title>
	<head>
	<body>
		<a href="./home.php">retour</a>
		<?php
		if(empty($_GET['userId']) || $_SESSION['newsession'] == $a['username']) {
		?>
		<a href="./deconnexion.php">Deconnexion</a>
		<?php } ?>
		<h2>Profil de <?= $a['username'] ?></h2>
		<div>Quelques informations : </div>
    	<ul>
			<?php
			if(empty($_GET['userId']) || $_SESSION['newsession'] == 'demo' || $_SESSION['newsession'] == $a['username']) {
			?>
            <li>Votre mail est : <b><?php echo $a['email'] ?></b></li>
			<?php } ?>
            <li>Date de création du compte : <b><?php echo $a['creationDate'] ?></b></li>
		</ul>
		<?php
		if(empty($_GET['userId']) || $_SESSION['newsession'] == $a['username']) {
		?>
		<h3>Changer de mot de passe :</h3>

		<form method="POST">
			<input type="password" name="oldpwd" placeholder="Ancien mot de passe" required /><br>
			<input type="password" name="newpwd" placeholder="Nouveau mot de passe" required /><br>
			<input type="password" name="confirmpwd" placeholder="Confirmer nouveau mot de passe" required /><br>
			<input type="submit" name="confirmButton" value="Valider">
		</form>

		<?php echo $error; } ?>

		<ul>

		<?php
		$postsQuery = $mysqli->query("SELECT * FROM articles WHERE userId = '" . $a['id'] . "' ORDER BY date DESC");
		while($post = $postsQuery->fetch()) { ?>

			<li><b><?= $post['title']; ?></b><br><?= $post['description']; ?><br><i><?= $post['date']; ?></i>

			<?php if($_SESSION['newsession'] == 'demo' || $_SESSION['newsession'] == $a['username']) { ?>

			<form method="POST" action=<?php echo '"dlpost.php?articleId=' . $post['articleId'] . '"' ?>>
                <input type="submit" name=<?php echo '"delete_post_' . $post['articleId'] . '"' ?> value="Supprimer l'article"></input> 
            </form></li>

			<?php } } ?>

		</ul>

	</body>
</html>