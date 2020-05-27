<?php

  if (isset($_SESSION['permissao'])) {
    $permissão = explode(";",$_SESSION['permissao']);
  }

?>

<nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-gradient-success">
    <div class="container">
      <a href="" class="navbar-brand h1 mb-0">
        <img src="bootstrap/vegan-symbol-png.png" width="30" height="30" class="d-inline-block align-top" alt="">

        Conscious Vegan</a>


      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSite">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse " id="navbarSite">

        <ul class="navbar-nav mr-auto">

          <li class="nav-item">
            <a class="nav-link" href="">Inicio</a>
          </li>
         
         <?php if(!isset($_SESSION['user'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="autenticacao/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="autenticacao/cadastro">Cadastre-se</a>
          </li>

         <?php endif; ?>

         <?php if(isset($_SESSION['permissao']) && in_array("admin",$permissão)):?>
          <li class="nav-item">
            <a class="nav-link" href="categoria">Categoria</a>
          </li>

          <?php endif;?>

         <?php if(isset($_SESSION['user'])): ?>
       
         
          <li class="nav-item">
            <a class="nav-link" href="usuario/profile/<?=$_SESSION['usuario']?>">Perfil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="autenticacao/logout">Sair</a>
          </li>

         <?php endif; ?>

         

        </ul>

       
        <form class="form-inline">
          <input class="form-control ml-4 mr-2" type="search" placeholder="Buscar...">
          <button class="btn btn-outline-dark" type="submit">ok</button>
        </form>

      </div>

    </div>
  </nav>