<?php

 define("PATH",$_SERVER['HTTP_HOST']."/vegan");

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) {
    define("PROTOCOLO","https");
} else {
    define("PROTOCOLO","http");
}

define('HOST_EMAIL', 'smtp.gmail.com');
define('EMAIL',"[email]");
define('PASSWORD_EMAIL',"[senha]");
define('NAME_HOST', 'Conscious Vegan');

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'VEGAN');




?>