<?php

spl_autoload_register(function($className) {
    if (file_exists("system/".$className.".php")) {
        require_once "system/".$className.".php";   
    } else if(file_exists("controller/".$className.".php")) {
        require_once "controller/".$className.".php";
    } else if(file_exists("model/".$className.".php")) {
        require_once "model/".$className.".php";
    }
});


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

$bootstrap = new Bootstrap($url);
