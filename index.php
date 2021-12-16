<!DOCTYPE html>
<?php
session_start();
if ($_SESSION["newsession"])
{
    echo "Bienvenue dans notre forum " . $_SESSION["newsession"];
    
}else{?>
    <p>T PAS CO</p>
    <?php
}
?>

