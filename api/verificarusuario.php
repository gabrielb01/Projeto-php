<?php

require_once "../config.php";

require_once "../model/database.php";



$database = new Database();
if ($_POST['tipo'] =="usuario") {
    $resultado = $database->query("SELECT usuario FROM USUARIO WHERE usuario=:usuario",[":usuario" => $_POST['data']]);

    if (count($resultado) == 0) {
        echo "Este usuário está disponível";
    } else {
        echo "Este usuário não está disponível";
    }
} 


if ($_POST['tipo'] =="email") {
    $resultado = $database->query("SELECT email FROM USUARIO WHERE email=:email",[":email" => $_POST['data']]);

    if (count($resultado) == 0) {
        echo "";
    } else {
        echo "Este email está sendo usando por outro usuário";
    }
}



?>