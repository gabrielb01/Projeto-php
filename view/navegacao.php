<?php

if (isset($_SESSION['permissao'])) {
  $permissão = explode(";", $_SESSION['permissao']);
}
?>

<nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-gradient-success">
  <div class="container">
    <a href="<?= PROTOCOLO ?>://<?= PATH ?>/" class="navbar-brand h1 mb-0"> Conscious Vegan</a>


    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSite">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSite">

      <ul class="navbar-nav mr-auto">

        <li class="nav-item">
          <a class="nav-link" href="<?= PROTOCOLO ?>://<?= PATH ?>/">Inicio</a>
        </li>

        <?php if (!isset($_SESSION['user'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= PROTOCOLO ?>://<?= PATH ?>/autenticacao/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= PROTOCOLO ?>://<?= PATH ?>/autenticacao/cadastro">Cadastre-se</a>
          </li>

        <?php endif; ?>

        <?php if (isset($_SESSION['permissao']) && in_array("admin", $permissão)) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= PROTOCOLO ?>://<?= PATH ?>/categoria">Categoria</a>
          </li>

        <?php endif; ?>


        <?php if (isset($_SESSION['user'])) : ?>


          <li class="nav-item">
            <a class="nav-link" href="<?= PROTOCOLO ?>://<?= PATH ?>/usuario/profile/<?= $_SESSION['usuario'] ?>">Perfil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= PROTOCOLO ?>://<?= PATH ?>/autenticacao/logout">Sair</a>
          </li>

        <?php endif; ?>



      </ul>


      <form class="form-inline" method="post" action="<?= PROTOCOLO ?>://<?= PATH ?>/receita/Search">
        <input class="form-control ml-4 mr-2" name="search" placeholder="Buscar..." required>
        <input type="submit" class="btn btn-outline-dark" value="Pesquisar">
      </form>

    </div>

  </div>
</nav>