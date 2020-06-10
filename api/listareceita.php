<?php

if (isset($_SESSION['user'])) {

    require_once "../config.php";

require_once "../model/Database.php";



$database = new Database();
if ($_POST['type'] == "add") {
    $resultado = $database->query("SELECT receitas_salvas FROM USUARIO WHERE id_usuario=:id", ['id' => $_POST['user']]);

    if ($resultado[0]['receitas_salvas'] != "") {
        $data = explode(";", $resultado[0]['receitas_salvas']);

        if (!in_array($_POST['identificacao'], $data)) {
            $data = $resultado[0]["receitas_salvas"] . ";" . $_POST['identificacao'];

            $database->exe_query("UPDATE USUARIO SET receitas_salvas=:receitas WHERE id_usuario=:id", [":receitas" => $data, ":id" => $_POST['user']]);

            echo "Receita adicionada a sua lista de receita com sucesso!";
        } else {
            echo "Essa receita já estar na sua lista!";
        }
    } else {


        $database->exe_query("UPDATE USUARIO SET receitas_salvas=:receitas WHERE id_usuario=:id", [":receitas" => $_POST['identificacao'], ":id" => $_POST['user']]);

        echo "Receita adicionada a sua lista de receita com sucesso!";
    }
}


if ($_POST['type'] == "remove") {
    $resultado = $database->query("SELECT receitas_salvas FROM USUARIO WHERE id_usuario=:id", ['id' => $_POST['user']]);
 
    if (count($resultado) > 0) {
        $data = explode(";", $resultado[0]['receitas_salvas']);

       $chave = array_search($_POST['identificacao'],$data);
       if ($chave !==false) {
           unset($data[$chave]);
       }

       $data = implode(";",$data);

       $database->exe_query("UPDATE USUARIO SET receitas_salvas=:receita WHERE id_usuario=:id",[":receita" => $data,":id" => $_POST['user'] ]);

       echo "Receita removida da sua lista de receita com sucesso!";
    }
}

}