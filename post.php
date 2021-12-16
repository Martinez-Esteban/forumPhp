<!DOCTYPE html>

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

<head>
    <title>login</title>
    <link href='./login.css' rel='style'>
</head>

<body>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $verifQuery = "SELECT password FROM user WHERE username= :username ;";
        $datas = [
            'username' => $_POST['username'],
        ];
        $results = $pdo->prepare($verifQuery);
        $results->execute($datas);
        $results=$results->fetchAll()[0]['password'];
        if (password_verify($_POST['password'],$results)){
            header("Location: ./index.html");
        }else{
            echo "mauvais mot de passe ou utilisateur";
            
        }
    }
    
   
    ?>
    <form class="registerForm" method="POST">
        <input type="text" name="title" required><br>
        <input type="text" name="description" required><br>
        <input type="date" name="date" required><br>
        <input type="submit" name="button" value="login"><br>
    </form>

    </html>