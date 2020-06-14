<?php

if (!defined('INDEX')) {
    die("Erro no sistema!");
}
?>
<br><br>
<div class="container">
    <div class="col-md-8 offset-md-2 col-sm-12 col-12">
        <div class="categoria-content">
            <form action="<?= PROTOCOLO ?>://<?= PATH ?>/categoria/validaredit/<?= $this->id ?>" method="post" class="form-add-categoria form">
                <div class="form-group">
                    <h3>Nome da Categora</h3>
                    <input type="text" class="form-control" name="categoria" autocomplete="off" value="<?= $this->resultado[0]['nome_categoria'] ?>" required>
                </div>
                <div class="form-group">
                    <h3>Descrição</h3>
                    <textarea class="form-control" name="descricao" required rows="5"><?= $this->resultado[0]['descricao'] ?></textarea>
                </div>
                <br><br>
                <div class="form-group">
                    <input type="submit" value="Editar" class="btn btn-success btn-submit">
                </div>
            </form>
        </div>
    </div>
</div>