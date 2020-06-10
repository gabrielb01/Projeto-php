<?php


 if (!defined('INDEX')) {
   die("Erro no sistema!");
 }

define("PATH",$_SERVER['HTTP_HOST']."/vegan");

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) {
    define("PROTOCOLO","https");
} else {
    define("PROTOCOLO","http");
}


define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'VEGAN');




?>