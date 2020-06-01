<?php

require_once "../config.php";

require_once "../model/database.php";



$database = new Database();
if ($_POST['tipo'] =="usuario") {
    $resultado = $database->query("SELECT usuario FROM USUARIO WHERE usuario=:usuario",[":usuario" => $_POST['data']]);

    if (count($resultado) == 0) {
        echo "0";
    } else {
        echo "1";
    }
} 


if ($_POST['tipo'] =="email") {
    $resultado = $database->query("SELECT email FROM USUARIO WHERE email=:email",[":email" => $_POST['data']]);

    if (count($resultado) == 0) {
        echo "0";
    } else {
        echo "1";
    }
}



?>