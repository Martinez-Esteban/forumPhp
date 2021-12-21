<?php
    if(isset($_POST['dl_user'])){
        echo("commande éxecuter!");
        $delete_user = $mysqli->query("DELETE FROM user WHERE username = ?");
        //execute la commande
    }
    else {
    echo" dhur";
    }
?>