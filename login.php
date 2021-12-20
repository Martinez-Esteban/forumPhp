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
        <link href='./login.css' rel='stylesheet'>
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
                header("Location: ./index.php");
                $_SESSION["newsession"]= $_POST['username'] ;
            }else{
                echo "mauvais mot de passe ou utilisateur";
                
            }
            
            
        }
        
       
        ?>
        <form class="registerForm" method="POST">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
            <input type="password" name="password" placeholder="Mot de passe" required><br>
            <input type="submit" name="button" value="Connexion"><br>
        </form>
        <a href="./register.php">Register</a>
    </body>
</html>