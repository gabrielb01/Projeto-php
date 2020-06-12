<?php

    if (!defined('INDEX')) {
      die("Erro no sistema!");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= PROTOCOLO ?>://<?= PATH ?>/css/main.css">
  <link rel="stylesheet" href="<?= PROTOCOLO ?>://<?= PATH ?>/css/<?=self::$style?>.css">
  <title><?=self::$title;?></title>
</head>
<body>