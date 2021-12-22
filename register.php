<?php
$dsn = "mysql:host=localhost:3306;dbname=forum";
$username = "root";
$password = "";

try{
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e){
    echo $e->getMessage();
    die();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link href='./register.css' rel='stylesheet'>
    </head>
    <body>
        <?php
        if(isset($_POST['profilPicture'])) {
            $pp = $post = $_POST['profilPicture'];
        } else {
            $pp = "https://www.cournondanseattitude.fr/wp-content/uploads/2019/07/blank-profile-picture-973460_640.png";
        }

        function verifyPassword($pdo) {
            if($_POST['password'] === $_POST['passwordVerified']) {
                addUser($pdo);
                return true;
            } else {
                return false;
            }
        }

        function addUser($pdo) {
            global $pp;

            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $mail = $_POST['mail'];

            $query = 'INSERT INTO user(username, password, email, creationDate, pp) VALUES(:username, :password, :mail, NOW(), :pp)';

            $datas = [
                'username' => $username,
                'password' => $password,
                'mail' => $mail,
                'pp' => $pp,
            ];

            $results = $pdo->prepare($query);
            $results->execute($datas);
        }
        ?>
        <form class="registerForm" method="POST" onsubmit="<?=verifyPassword($pdo)?>">
            <input type="text" name="username" required placeholder="Nom d'utilisateur*"><br>
            <input type="password" name="password" required placeholder="Mot de passe*"><br>
            <input type="password" name="passwordVerified" required placeholder="Confirmation du mdp*"><br>
            <input type="email" name="mail" required placeholder="E-mail*"><br>
            <input type="submit" name="button" value="Créer un compte"><br>
        </form>
        <a href="./login.php">Login</a>
    </body>
</html>