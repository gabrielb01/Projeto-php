
<?php
$database = ReceitaController::getConnect();

$receita = $database->query("SELECT * FROM RECEITA WHERE id_receita=:id", [':id' => $id]);
$criador = $database->query("SELECT usuario,nome,sobrenome FROM USUARIO WHERE id_usuario=:id", [":id" => $receita[0]['id_usuario']]);
$ingredientes = explode(',', $receita[0]['ingredientes']);
?>

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
    <div class="single-receita">
        <div class="row">
            <div class="col-md-7 col-12">
                <div class="single-receita-content">
                    <img src="<?= PROTOCOLO . "://" . PATH . "/" . $receita[0]['foto_receita'] ?>" width="100%" height="300px">
                    <div class="border p-3">  
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        <div id="singleOption">
                            <div class="col-md-2 p-0 col-3">
                                <ul class="list-group">
                                <?php if ($_SESSION['user'] == $receita[0]['id_usuario']) : ?>
                                    <a href="<?= PROTOCOLO ?>://<?= PATH ?>/receita/edit/<?= $receita[0]['id_receita'] ?>">
                                        <li class="list-group-item">Editar</li>
                                    </a>
                                    
                                    <a id="trash-Receita" href="#" name="<?= $receita[0]['id_receita'] ?>">
                                    <li class="list-group-item">Excluir</li> </a>
                                   <?php endif; ?>

                                    <?php if ($_SESSION['user'] != $receita[0]['id_usuario']) : ?>
                                   <a href="<?= PROTOCOLO ?>://<?= PATH ?>/receita/edit/<?= $receita[0]['id_receita'] ?>">
                                        <li class="list-group-item">Salvar Receita</li>
                                    </a>
                                    <?php endif; ?>
                                   
                                </ul>
                            </div>
                        </div>
                        <h1><?= $receita[0]['titulo'] ?></h1>
                        <hr>
                        <b>Categoria: </b><a href="<?= PROTOCOLO . "://" . PATH . "/categoria/show/" . $receita[0]['categoria'] ?>"> <?= $receita[0]['categoria'] ?></a><br>
                        <b>Criador: </b><a href="<?= PROTOCOLO . "://" . PATH . "/usuario/profile/" . $criador[0]['usuario'] ?>"> <?= $criador[0]['nome'] . ' ' . $criador[0]['sobrenome'] ?></a>
                        <br><br>
                        <h3>Ingredientes</h3>
                        <hr>

                        <?php foreach ($ingredientes as $i) :  ?>
                            <p><?= $i ?></p>
                        <?php endforeach; ?>
                        <br><br>
                        <h3>Modo de Fazer</h3>
                        <hr>
                        <div class="p-1">
                            <?= $receita[0]['mododefazer'] ?>
                        </div>
                        <br>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>