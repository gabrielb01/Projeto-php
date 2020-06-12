<?php

 define("PATH",$_SERVER['HTTP_HOST']."/vegan");

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) {
    define("PROTOCOLO","https");
} else {
    define("PROTOCOLO","http");
}

define('HOST_EMAIL', 'smtp.gmail.com');
define('EMAIL',"contato.escolavirtualdecursos@gmail.com");
define('PASSWORD_EMAIL',"090295thetime1");
define('NAME_HOST', 'Conscious Vegan');

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'VEGAN');




?>