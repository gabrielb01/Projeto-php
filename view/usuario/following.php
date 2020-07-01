<?php

if (isset($this->mensagem)) {
    die($this->mensagem);
}
?>
<div class="container">
    <div class="row">
        <?php foreach ($this->seguidores as $seguidor) : ?>
            <div class="col-md-3">
                <a href="<?= PROTOCOLO ?>://<?= PATH ?>/u/profile/<?= $seguidor['usuario'] ?>">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?=$seguidor['nome']?> <?=$seguidor['sobrenome']?></h5>
                        </div>
                    </div>
                </a>
            </div>

        <?php endforeach; ?>
    </div>
</div>