<?php 

$mysqli = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");

if(isset($_GET['search'])){
    echo("Voici les résultats pour : " . $_GET['search']);
    $delete_user = $mysqli->prepare("SELECT * FROM articles WHERE title LIKE '%".$_GET['search']."%'");
    $delete_user ->execute();
    echo "<ul>";
    while ($row = $delete_user->fetch()) {
        echo "<li><b><a href=./details.php?articleId=".$row['articleId'].">".$row['title']."</a></b><br>".$row['description']."<br><i>".$row['date']."</i></li>";  
    }
    echo "</ul>";  
} else {
    echo "something went wrong";
}
?>