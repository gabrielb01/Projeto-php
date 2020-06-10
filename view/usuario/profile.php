<?php

    if (!defined('INDEX')) {
      die("Erro no sistema!");
    }
?>
<div class="div-popup">
    <form class="form" method="post" enctype="multipart/form-data" action="<?= PROTOCOLO ?>://<?= PATH ?>/u/editphoto">
        <div class="close">&times</div>
        <h3>Perfil</h3>
        <img id="imagemPerfil" width="200px" height="200px" />
        <input type="file" name="fotoProfile" accept="image/*" id="fotoPerfil" required /><br>
        <input type="submit" value="Adicionar" class="btn btn-success ml-5 mt-2"><br>
    </form>
</div>



<div class="background-img" style="background-image:url('<?= PROTOCOLO ?>://<?= PATH ?>/img/default/a.png')">
    <div class="profile-flex">
        <div class="profile-img" style="background-image:url('<?= PROTOCOLO . '://' . PATH . '/' . $this->dados[0]['foto_perfil'] ?>')">
            <?php if($_SESSION['usuario'] == $this->usuario):?>
            <div class="edit-image">
                <i class="fa fa-camera" aria-hidden="true"></i>
            </div>
            <?php endif; ?>
        </div>
        <h3><?= $_SESSION['nome_full'] ?></h3>
    </div>
    <?php if($_SESSION['usuario'] == $this->usuario):?>
    <a href="<?= PROTOCOLO ?>://<?= PATH ?>/u/edit/editar-perfil" class="perfil-edit">Editar Perfil</a>
    <?php endif; ?>
</div>

<div class="container">
    <div class="nav-flex">
        <div class="nav-box">
            <h4><a href="<?= PROTOCOLO ?>://<?= PATH ?>/receita/detalhes/<?=$this->dados[0]['id_usuario']?>"><?= ($_SESSION['usuario'] == $this->usuario ? "Minha Receitas" :"Receitas de ".$this->usuario)?></a></h4><br>
        </div>
        <?php if($_SESSION['usuario'] == $this->usuario):?>
        <a href="<?= PROTOCOLO ?>://<?= PATH ?>/u/listar">
            <div class="nav-box">
                <h4>Receitas <br> Salvas</h4>
            </div>
        </a>
        <a href="<?= PROTOCOLO ?>://<?= PATH ?>/receita/cadastrarReceita">
            <div class="nav-box">
                <h4><a href="<?= PROTOCOLO ?>://<?= PATH ?>/receita/new">Nova Receita</a></h4><br>
            </div>
        </a>
        <?php endif; ?>
    </div>
</div>