<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
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
        <title>login</title>
        <link href='css/login.css' rel='stylesheet'>
    </head>
    <body>
        <?php
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $verifQuery = "SELECT password FROM user WHERE username= :username ;";
            $datas = [
                'username' => $_POST['username'],
            ];
            $results = $pdo->prepare($verifQuery);
            $results->execute($datas);
            $results=$results->fetchAll()[0]['password'];
            if (password_verify($_POST['password'],$results)){
                header("Location: ./home.php");
                $_SESSION["newsession"]= $_POST['username'] ;
            }else{
                echo "mauvais mot de passe ou utilisateur";
                
            }
        }
        
       
        ?>
        <div class="background">
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <form class="registerForm" method="POST">
            <h3>Connectez vous ! :)</h3>
            <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
            <input type="password" name="password" placeholder="Mot de passe" required><br>
            <input type="submit" id="connexionButton" name="button" value="Connexion"><br>
            <a href="./register.php" id="registerButton">Register</a>
        </form>
        
    </body>
</html>