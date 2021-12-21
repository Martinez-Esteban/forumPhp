<?php 

$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");

if(isset($_GET['search'])){
    echo("commande executer!");
    $delete_user = $mysqli->prepare("SELECT * FROM articles WHERE title LIKE '%".$_GET['search']."%'");
    $delete_user ->execute();
    echo "<ul>";
        while ($row = $delete_user->fetch()) {
            echo "<li><a href=./details?articleId=".$row['articleId'].">".$row['title']."<br>".$row['description']."</a></li>";  
        }
    echo "</ul>";    
    
}
else {
    echo "c'est la sauce";
}


?>
