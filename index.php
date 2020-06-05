<?php


$url = (isset($_GET['url']) ? $_GET['url'] : "");



if ($url!=""){
    $url = explode("/",$url);
}

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) {
    define("PROTOCOLO","https");
} else {
    define("PROTOCOLO","http");
}


session_start();




require_once "config.php";

require_once "funcoes/funcoes.php";

require_once "controller/errorController.php";

require_once "model/database.php";


require_once "bootstrap.php";



$bootstrap = new Bootstrap($url);
