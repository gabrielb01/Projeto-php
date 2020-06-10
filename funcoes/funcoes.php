<?php


if (!defined('INDEX')) {
  die("Erro no sistema!");
}

function limpar($arg)
{
    return htmlentities($arg,ENT_QUOTES,"UTF-8");
}

function alert()
{

    if (isset($_SESSION["ERROR_DATA_PASSWORD"])) {
        echo "<div class='mtop'><div class='alert alert-dark' role='alert >";
        echo $_SESSION["ERROR_DATA_PASSWORD"];
        echo "</div>";
        unset($_SESSION["ERROR_DATA_PASSWORD"]);
    }
    if (isset($_SESSION["ERROR_DATA_OUT"])) {
        echo "<div class='alert alert-dark' role='alert'>";
        echo $_SESSION["ERROR_DATA_OUT"];     
        echo "</div>";
        unset($_SESSION["ERROR_DATA_OUT"]);
    }
    if (isset($_SESSION["CADASTRO_SUCESSO"])) {
        echo " <div class='alert alert-dark' role='alert'>";   
        echo $_SESSION["CADASTRO_SUCESSO"];
        echo "</div>";
        unset($_SESSION["CADASTRO_SUCESSO"]);
    }
}


?>

