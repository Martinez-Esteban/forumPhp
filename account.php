<?php
$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");
session_start();

function rrmdir($dir) { 
	if (is_dir($dir)) { 
	$objects = scandir($dir);
	foreach ($objects as $object) { 
		if ($object != "." && $object != "..") { 
		if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
			rrmdir($dir. DIRECTORY_SEPARATOR .$object);
		else
			unlink($dir. DIRECTORY_SEPARATOR .$object); 
		} 
	}
	rmdir($dir); 
	} 
}

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
	$errorMail = "";
	$ppMsg = "";

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

	// Fonction pour changer le mail
	if(isset($_POST['confirmMail'])) {
		global $a;
		global $mysqli;
		if(password_verify($_POST['pwd'], $a['password'])) {
			$query = "UPDATE user SET email = '" . $_POST['newmail'] . "' WHERE username = '" . $_SESSION['newsession'] . "'";
			$update = $mysqli->prepare($query);
			$update->execute();
			$errorMail = "E-Mail modifié avec succès !";
		} elseif (!password_verify($_POST['pwd'], $a['password'])) {
			$errorMail = "Mauvais mot de passe.";
		} else {
			$errorMail = "Something went wrong ...";
		}
	}

	if(isset($_POST['validProfil'])){
		try {
			rrmdir("./images/forum/".$a['id']);
		}catch(Exception $e){
			echo "catch";
		}
		mkdir("./images/forum/".$a['id'], 0700);
		$tempName = $_FILES['pp']['tmp_name'];
		$name = $_FILES['pp']['name'];
		move_uploaded_file($tempName, "./images/forum/".$a['id']."/".$name);
		$path = "./images/forum/".$a['id']."/".$name;
		$query = "UPDATE user SET pp = '" . $path . "' WHERE username = '" . $_SESSION['newsession'] . "'";
		$update = $mysqli->prepare($query);
		$update->execute();
	}

?>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href='css/account.css' rel='stylesheet'>
		<title>Profil de <?php echo $a['username'] ?></title>
	<head>
	<body>
		<nav class="nav">
			<ul>
			<li class="home"><a href="./home.php">Accueil</a></li>
			<?php if(empty($_GET['userId']) || $_SESSION['newsession'] == $a['username']) { ?>
			<li class="deco"><a href="./deconnexion.php">Deconnexion</a></li>
			<?php } ?>
		</nav>
		<div class="container">
			<h2>Profil de <?= $a['username'] ?></h2><br><br><br><br><br>
			<div class="avatar-flip">
				<img src="<?php echo $a['pp'] ?>" height="150" width="150">
				<img src="http://i1112.photobucket.com/albums/k497/animalsbeingdicks/abd-3-12-2015.gif~original" height="150" width="150">
  			</div>
			<h3>Vos informations</h3>
			<ul>
				<?php
				if(empty($_GET['userId']) || $_SESSION['newsession'] == 'demo' || $_SESSION['newsession'] == $a['username']) {
				?>
				<p>Votre mail est : <b><?php echo $a['email'] ?></b></p>
				<?php } ?>
				<p>Date de création du compte : <b><?php echo $a['creationDate'] ?></b></p>
			</ul>		
		</div>
		<div class="container"> 
			<ul>

			<?php
			$postsQuery = $mysqli->query("SELECT * FROM articles WHERE userId = '" . $a['id'] . "' ORDER BY date DESC");
			while($post = $postsQuery->fetch()) { ?>

				<li><b><?= $post['title']; ?></b><br><?= $post['description']; ?><br><i><?= $post['date']; ?></i>

				<?php if($_SESSION['newsession'] == 'demo' || $_SESSION['newsession'] == $a['username']) { ?>

				<form method="POST" action=<?php echo '"dlpost.php?articleId=' . $post['articleId'] . '"' ?>>
					<input type="submit" name=<?php echo '"delete_post_' . $post['articleId'] . '"' ?> value="Supprimer l'article"></input> 
				</form>
				<form method="POST" action=<?php echo '"edit.php?title=' . $post['title'] . '&content=' . $post['description'] . '&uid=' . $post['userId'] . '&articleId=' . $post['articleId'] . '"' ?>>
					<input type="submit" name="edit" value="Modifier l'article">
				</form></li>

				<?php } } ?>

			</ul>
		</div>
		
		<?php
		if(empty($_GET['userId']) || $_SESSION['newsession'] == $a['username']) {
		?>
		<h3 style="color:white;">Changer de mot de passe :</h3>

		<form method="POST">
			<input type="password" name="oldpwd" placeholder="Ancien mot de passe" required /><br>
			<input type="password" name="newpwd" placeholder="Nouveau mot de passe" required /><br>
			<input type="password" name="confirmpwd" placeholder="Confirmer nouveau mot de passe" required /><br>
			<input type="submit" name="confirmButton" value="Valider">
		</form>

		<?php echo $error; ?>

		<h3 style="color:white;">Changer de mail :</h3>

		<form method="POST">
			<input type="email" name="newmail" placeholder="Nouveau mail" required /><br>
			<input type="password" name="pwd" placeholder="Mot de passe" required /><br>
			<input type="submit" name="confirmMail" value="Valider">
		</form>
		<h3 style="color:white;">Changer de photo de profile:</h3>
		<form method="POST" enctype="multipart/form-data">
			<input type="file" name="pp" placeholder="Nouvelle PP" /><br>
			<input type="submit" name="validProfil" value="Valider">
		</form>
	
		<?php echo $errorMail; } ?>
		
	</body>
</html>