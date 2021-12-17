<!DOCTYPE html>
<?php
session_start();
if ($_SESSION["newsession"])
{
    echo "Bienvenue dans notre forum " . $_SESSION["newsession"];
?>
    <hr>
    <a href="./posts.php">Articles</a>
    <hr>
    <a href="./deconnexion.php">Déconnexion</a>

<?php
} else {
    echo "T PA CO";
}
?>

