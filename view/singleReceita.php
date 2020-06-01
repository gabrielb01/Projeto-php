<?php


$database = ReceitaController::getConnect();

$receita = $database->query("SELECT * FROM RECEITA WHERE id_receita=:id", [':id' => $id]);
$criador = $database->query("SELECT usuario,nome,sobrenome FROM USUARIO WHERE id_usuario=:id", [":id" => $receita[0]['id_usuario']]);
$ingredientes = explode(',', $receita[0]['ingredientes']);
?>



<br><br>

<div class="container">
    <div class="row">
        <div class="single-receita">
            <div class="col-md-7 col-12">
                <img src="<?= PROTOCOLO . "://" . PATH . "/" . $receita[0]['foto_receita'] ?>" width="100%" height="300px">
                <div class="border p-3">
                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    <div id="singleOption">
                        <div class="col-md-2 p-0 col-3">
                            <ul class="list-group">
                                <li class="list-group-item">Editar</li>
                                <li class="list-group-item">Excluir</li>
                            </ul>
                        </div>
                    </div>
                    <h1><?= $receita[0]['titulo'] ?></h1>
                    <hr>
                    <b>Categoria: </b><a href="#"> <?= $receita[0]['categoria'] ?></a><br>
                    <b>Criador: </b><a href="<?= PROTOCOLO . "://" . PATH . "/usuario/profile/" . $criador[0]['usuario'] ?>"> <?= $criador[0]['nome'] . ' ' . $criador[0]['sobrenome'] ?></a>
                    <br>
                    <h3>Ingredientes</h3>

                    <?php foreach ($ingredientes as $i) :  ?>
                        <p><?= $i ?></p>
                    <?php endforeach; ?>

                    <h3>Modo de Fazer</h3>
                    <div class="p-1">
                        <?= $receita[0]['mododefazer'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>