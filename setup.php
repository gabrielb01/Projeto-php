<?php

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'VEGAN');
define("PATH",$_SERVER['HTTP_HOST']."/vegan");
define("PROTOCOLO","http");


$pdo = new PDO('mysql:host=' . HOST ,  USER, PASS);
$pdo->query("DROP DATABASE VEGAN"

);
$pdo->query("CREATE DATABASE IF NOT EXISTS VEGAN");

$pdo = new pdo('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASS);


$pdo->query("ALTER DATABASE ".DBNAME." CHARSET = Latin1 COLLATE = latin1_swedish_ci");

$pdo->query("CREATE TABLE USUARIO(
    id_usuario              int auto_increment PRIMARY KEY not null,
    usuario                 varchar(255),     
    email                   varchar(255),
    permissao               varchar(255),
    senha                   varchar(255),
    nome                    varchar(255),
    sobrenome               varchar(255),
    receitas_salvas         text DEFAULT '',
    sexo                    char(1),
    ativo                   boolean DEFAULT 0,
    token                   varchar(255),
    token_ativo             char(1) DEFAULT 0,
    token_ativo_password    char(1) DEFAULT 0,
    usuarios_seguindos      text DEFAULT '',
    foto_perfil             varchar(255));");


$pdo->query("CREATE TABLE RECEITA(
    id_receita          int auto_increment PRIMARY KEY not null,
    titulo              varchar(255),     
    ingredientes        varchar(255),
    mododefazer         text,
    foto_receita         varchar(255),
    categoria           varchar(255),
    id_usuario          int,
    criando_em          DATETIME,
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario));");



$pdo->query("CREATE TABLE CATEGORIA(
    id_categoria        int auto_increment PRIMARY KEY not null,
    nome_categoria       varchar(255),
    descricao           text)"
    );




$foto = '/img/default/default.png';

$pdo->query("INSERT INTO USUARIO(usuario,email,permissao,senha,nome,sobrenome,sexo,ativo,foto_perfil) VALUES ('gabriel','gabriel@teste.com','user;admin','$2y$10$4OS8oPpNIuG/s9N0lqT2MeIBH3DLNQZEoPN8zqEpA/7BrMpNEGqpK','Gabriel','Alves','M','1','".$foto."')");


echo "Tudo Feito!";

?>