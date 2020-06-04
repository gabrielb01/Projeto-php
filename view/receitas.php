<?php if (isset($_SESSION["SUCCESS_DATA_IN"])) : ?>

    <div class="alert alert-success" role="alert">
        <?php echo $_SESSION["SUCCESS_DATA_IN"]; ?>

    </div>

<?php



    unset($_SESSION["SUCCESS_DATA_IN"]);
endif;
?>
<br><br>
<div class="container">
    <div class="row">
        <a href="<?= PROTOCOLO ?>://<?= PATH ?>/receita/new" class="btn btn-primary btn-lg">Cadastrar Receita</a>
    </div>
</div>

<br><br>

<div class="container">
    <div class="row">
        <?php

        $database = ReceitaController::getConnect();

        $receitas = $database->query("SELECT * FROM RECEITA WHERE id_usuario=:id ORDER BY criando_em DESC", [':id' => $_SESSION['user']]);

        foreach ($receitas as $receita) :
        ?>
            <div class="col-md-3 col-sm-4 col-12">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="<?=PROTOCOLO.'://'.PATH.'/'. $receita['foto_receita'] ?>" height="200px" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><?= $receita['titulo'] ?></h5>
                        <p class="card-text"><?= substr($receita['mododefazer'], 0, 100) ?></p>
                        <a href="<?= PROTOCOLO ?>://<?= PATH ?>/receita/single/<?= $receita['id_receita'] ?>" class="btn btn-primary">Ver Receita</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>