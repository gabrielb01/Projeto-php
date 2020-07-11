<?php

if (!defined('INDEX')) {
    die("Erro no sistema!");
}
?>
<div class="div-popup">
    <form class="form" method="post" enctype="multipart/form-data" action="<?= PROTOCOLO ?>://<?= PATH ?>/u/editphoto">
        <div class="close">&times</div>
        <h3>Perfil</h3>
        <img id="imagemPerfil" width="200px" height="200px" src="<?= PROTOCOLO . '://' . PATH . '/' . $this->dados[0]['foto_perfil'] ?>" />
        <input type="file" name="fotoProfile" accept="image/*" id="fotoPerfil" required /><br>
        <input type="submit" value="Salvar" class="btn btn-success ml-5 mt-3"><br>
    </form>
</div>



<div class="background-img" style="background-image:url('<?= PROTOCOLO ?>://<?= PATH ?>/img/default/a.png')">
    <div class="profile-flex">
        <div class="profile-img" style="background-image:url('<?= PROTOCOLO . '://' . PATH . '/' . $this->dados[0]['foto_perfil'] ?>')">
            <?php if ($_SESSION['usuario'] == $this->usuario) : ?>
                <div class="edit-image">
                    <i class="fa fa-camera" aria-hidden="true"></i>
                </div>
            <?php endif; ?>
        </div>
        <h3><?= $_SESSION['nome_full'] ?></h3>
    </div>
        <div class="row">
            <div class="subnav">
                <a href="<?= PROTOCOLO ?>://<?= PATH ?>/u/edit/editar-perfil" class="perfil-edit">Editar Perfil</a>
                &nbsp;&nbsp;&nbsp;
                <?php if($_SESSION['usuario'] != $this->dados[0]['usuario']):?>

                    <?php
                        $database = new Database();
                        $data = $database->query("SELECT usuarios_seguindos FROM USUARIO WHERE id_usuario=:id",[':id' => $_SESSION['user']]);

                        if ($data[0]['usuarios_seguindos'] != "") {
                            $array_data = explode(';',  $data[0]['usuarios_seguindos'] );

                            if (in_array($this->dados[0]['usuario'], $array_data)) {
                                echo  "<a href=".PROTOCOLO."://".PATH."/u/desseguirUsuario/".$this->dados[0]['usuario'].">Seguindo</a>";
                            } else {
                                echo  "<a href=".PROTOCOLO."://".PATH."/u/seguirUsuario/".$this->dados[0]['usuario'].">Seguir</a>";
                            }
                        } else {
                            echo  "<a href=".PROTOCOLO."://".PATH."/u/seguirUsuario/".$this->dados[0]['usuario'].">Seguir</a>";
                        }
                        
                        
                    ?>

                <? endif; ?>
                <?php if($_SESSION['usuario'] == $this->dados[0]['usuario'] ):?>
                    <a href="<?=PROTOCOLO?>://<?=PATH?>/u/following">Seguindo</a>
                <?php endif; ?>
            </div>
        </div>
</div>
<br>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="card">
                <a class="nav-box" href="<?= PROTOCOLO ?>://<?= PATH ?>/receita/detalhes/<?= $this->dados[0]['id_usuario'] ?>">
                    <?= ($_SESSION['usuario'] == $this->usuario ? "Minha Receitas" : "Receitas de " . $this->usuario) ?>
                </a>
            </div>

        </div>
        <?php if ($_SESSION['usuario'] == $this->usuario) : ?>
            <div class="col-md-4 col-12">

                <div class="card">
                    <a class="nav-box" href="<?= PROTOCOLO ?>://<?= PATH ?>/u/listar">
                        Receitas Salvas
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="card">
                    <a class="nav-box" href="<?= PROTOCOLO ?>://<?= PATH ?>/receita/new">
                        Nova Receita
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<br>
<br>
<br>