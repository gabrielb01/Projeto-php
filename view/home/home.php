<?php

    if (!defined('INDEX')) {
      die("Erro no sistema!");
    }
?>
<div class="container">
  <div class="row justify-content-center">
    <div class="row mb-5 ">
      <div class="col-sm-6 col-nd-4">
        <div class="card mt-3">
          <img class="card-img-top" src="img/default/a.png" alt="Imagem de capa do card">
          <div class="card-body card text-center">
            <div class="card-title text-editado">Receitas</div>
            <a href="<?=PROTOCOLO . "://" . PATH ."/receita"?>" class="btn btn-success">Visitar</a>
          </div>
        </div>

      </div>

      <div class="col-sm-6 col-nd-4 ">
        <div class="card mt-3">
          <img class="card-img-top" src="img/default/b.png" alt="Imagem de capa do card">
          <div class="card-body card text-center">
            <div class="card-title text-editado"> Nutrientes</div>
            <a href="#" class="btn btn-success">Visitar</a>
          </div>
        </div>

      </div>

      <div class="col-sm-6 col-nd-4">
        <div class="card mt-3">
          <img class="card-img-top" src="img/default/c.png" alt="Imagem de capa do card">
          <div class="card-body card text-center">
            <div class="card-title text-editado">Substituir</div>
            <a href="#" class="btn btn-success">Visitar</a>
          </div>
        </div>

      </div>

      <div class="col-sm-6 col-nd-4">
        <div class="card mt-3">
          <img class="card-img-top" src="img/default/d.png" alt="Imagem de capa do card">
          <div class="card-body card text-center">
            <div class="card-title text-editado">Outros</div>
            <a href="#" class="btn btn-success">Visitar</a>
          </div>
        </div>


      </div>


    </div>
  </div>
</div>