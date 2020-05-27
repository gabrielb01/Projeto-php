<?php

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'VEGAN');
define("PATH",$_SERVER['HTTP_HOST']);
define("PROTOCOLO","http");


$pdo = new PDO('mysql:host=' . HOST ,  USER, PASS);
$pdo->query("DROP DATABASE VEGAN");
$pdo->query("CREATE DATABASE IF NOT EXISTS VEGAN");

$pdo = new pdo('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASS);


$pdo->query("CREATE TABLE USUARIO(
    id_usuario          int auto_increment PRIMARY KEY not null,
    usuario             varchar(255),     
    email               varchar(255),
    permissao           varchar(255),
    senha               varchar(255),
    nome                varchar(255),
    sobrenome           varchar(255),
    sexo                char(1),
    ativo               boolean ,
    foto_perfil         varchar(255));");



$pdo->query("CREATE TABLE CATEGORIA(
    id_categoria        int auto_increment PRIMARY KEY not null,
    nome_categoria       varchar(255),
    descricao           text)"
    );




$foto =PROTOCOLO. '://'.PATH.'/img/default/default.png';

$pdo->query("INSERT INTO USUARIO(usuario,email,permissao,senha,nome,sobrenome,sexo,foto_perfil) VALUES ('gabriel','gabriel@teste.com','user;admin','$2y$10$4OS8oPpNIuG/s9N0lqT2MeIBH3DLNQZEoPN8zqEpA/7BrMpNEGqpK','Gabriel','Alves','M','".$foto."')");


echo "Tudo Feito!";

?>